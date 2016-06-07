<?php
namespace S3b0\EcomNewsletterSubscription\Controller;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015 Sebastian Iffland <Sebastian.Iffland@ecom-ex.com>, ecom instruments GmbH
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use In2code\Powermail\Utility\SessionUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * SubscriptionController
 */
class SubscriptionController extends \Ecom\EcomToolbox\Controller\ActionController
{

    /**
     * @var array|null
     */
    protected $noReplyEmailAddresses = null;

    /**
     * @var array
     */
    protected $senderEmailAddresses = [];

    /**
     * @var array
     */
    protected $carbonCopyEmailAddresses = [];

    /**
     * @var \S3b0\EcomNewsletterSubscription\Domain\Repository\SubscriptionRepository
     * @inject
     */
    protected $subscriptionRepository;

    /**
     * @var \TYPO3\CMS\Frontend\Page\PageRepository
     * @inject
     */
    protected $pageRepository;

    /**
     * Initializes the controller before invoking an action method.
     *
     * @return void
     */
    protected function initializeAction()
    {
        // ecom online root page, may be overwritten by TS
        $this->settings['rootPage'] = $this->settings['rootPage'] ?: 13;
        $this->settings['mail']['noReplyEmail'] = $this->settings['mail']['noReplyEmail'] ?: 'noreply@ecom-ex.com';
        $this->settings['mail']['senderName'] = $this->settings['mail']['senderName'] ?: ($GLOBALS['TYPO3_CONF_VARS']['SYS']['sitename'] ?: null);
        #$this->settings['mail']['carbonCopy'] = $this->settings['mail']['carbonCopy'] ?: 'marketing@ecom-ex.com ecom Marketing';

        if (in_array($this->request->getControllerActionName(),
            ['create', 'confirm', 'delete', 'resendActivationMail'])) {
            if ($this->settings['mail']['noReplyEmail'] && GeneralUtility::validEmail($this->settings['mail']['noReplyEmail']) && $this->settings['mail']['senderName']) {
                $this->noReplyEmailAddresses = [$this->settings['mail']['noReplyEmail'] => $this->settings['mail']['senderName']];
            }
            if ($this->settings['mail']['senderEmail'] && GeneralUtility::validEmail($this->settings['mail']['senderEmail']) && $this->settings['mail']['senderName']) {
                $this->senderEmailAddresses = [$this->settings['mail']['senderEmail'] => $this->settings['mail']['senderName']];
            } else {
                $this->senderEmailAddresses = \TYPO3\CMS\Core\Utility\MailUtility::getSystemFrom();
            }
            if ($this->settings['mail']['carbonCopy']) {
                foreach (explode(',', $this->settings['mail']['carbonCopy']) as $carbonCopyEmailAddress) {
                    $tokens = GeneralUtility::trimExplode(' ', $carbonCopyEmailAddress, true, 2);
                    if (GeneralUtility::validEmail($tokens[0])) {
                        $this->carbonCopyEmailAddresses[$tokens[0]] = $tokens[1];
                    }
                }
            }
        }
    }

    /**
     * action new
     *
     * @param \S3b0\EcomNewsletterSubscription\Domain\Model\Subscription $newSubscription
     * @param string $dismissibleAlert
     * @ignorevalidation $newSubscription
     * @return void
     */
    public function newAction(\S3b0\EcomNewsletterSubscription\Domain\Model\Subscription $newSubscription = null, $dismissibleAlert = '')
    {
        $privacyPolicyPage = $this->pageRepository->getPage($this->settings['dpspid'] ?: 1);
        if ($language = $this->getTypoScriptFrontendController()->sys_language_uid) {
            $privacyPolicyPage = $this->pageRepository->getPageOverlay($privacyPolicyPage, $language);
        }

        $this->view->assignMultiple([
            'newSubscription' => $newSubscription,
            'dismissibleAlert' => $dismissibleAlert,
            'dpsNoOL' => !boolval($privacyPolicyPage['_PAGES_OVERLAY'])
        ]);
    }

    /**
     * action create
     *
     * @param \S3b0\EcomNewsletterSubscription\Domain\Model\Subscription $newSubscription
     * @param string $url Honeypot check
     * @return void
     */
    public function createAction(\S3b0\EcomNewsletterSubscription\Domain\Model\Subscription $newSubscription = null, $url = null)
    {
        // Check given object
        if ($url || !$newSubscription instanceof \S3b0\EcomNewsletterSubscription\Domain\Model\Subscription) {
            $this->redirectToUri($this->uriBuilder->reset()->build());
            // Avoid duplicates, check for existing records
            /** @var \S3b0\EcomNewsletterSubscription\Domain\Model\Subscription $subscription */
        } elseif (($subscription = $this->subscriptionRepository->findByEmail($newSubscription->getEmail())) instanceof \S3b0\EcomNewsletterSubscription\Domain\Model\Subscription) {
            $newSubscription->setEmail('');
            $this->forward('new', null, null, [
                'newSubscription' => $newSubscription,
                'dismissibleAlert' => $subscription->isHidden() ? $this->getStandAloneTemplate('Notifications/NotConfirmed',
                    ['subscription' => $subscription]) : $this->getStandAloneTemplate('Notifications/DuplicateFound')
            ]);
        } else {
            // Generate hash value for confirmation
            $newSubscription->setHash(uniqid());
            // Get name parts out of given name
            $nameTokens = GeneralUtility::trimExplode(' ', $newSubscription->getName(), true, 2);
            $newSubscription->setFirstName($nameTokens[0]);
            $newSubscription->setLastName($nameTokens[1] ?: '');
            // Create database entry
            $this->createRecord($newSubscription);
            $this->resendActivationMailAction($newSubscription);
        }
    }

    /**
     * action confirm
     *
     * @param string $hash
     * @param string $email
     * @return void
     */
    public function confirmAction($hash, $email)
    {
        /** @var \S3b0\EcomNewsletterSubscription\Domain\Model\Subscription $subscription */
        $subscription = $this->subscriptionRepository->findUnconfirmedByHashAndEmail($hash, $email);

        // If subscription was found and creation date is not older than a week (link validity duration)
        if ($subscription instanceof \S3b0\EcomNewsletterSubscription\Domain\Model\Subscription && (time() - $subscription->getCreationDate() < 604800)) {
            $subscription->setHidden(false);
            $this->updateRecord($subscription);
            $this->view->assign('subscription', $subscription);

            /** @var \TYPO3\CMS\Core\Mail\MailMessage $mailToSender */
            $mailToSender = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
            $mailToSender->setContentType('text/html');

            // Email to sender
            $mailToSender->setFrom($this->noReplyEmailAddresses ?: $this->senderEmailAddresses)
                ->setTo([$subscription->getEmail() => $subscription->getName()])
                ->setSubject($this->settings['mail']['senderSubject'] ?: LocalizationUtility::translate('mail_subject_generic',
                        $this->extensionName) . LocalizationUtility::translate('mail_subject_confirmed',
                        $this->extensionName))
                ->setBody($this->getStandAloneTemplate('Email/EmailConfirmed', [
                    'subscription' => $subscription
                ]))
                ->send();

            /** @var \TYPO3\CMS\Core\Mail\MailMessage $mailToReceiver */
            $mailToReceiver = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
            $mailToReceiver->setContentType('text/html');

            // Email to receiver
            $mailToReceiver->setFrom([$subscription->getEmail() => "{$subscription->getFirstName()} {$subscription->getLastName()}"])
                ->setCc($this->carbonCopyEmailAddresses)
                ->setTo(['Alexander.Maertens@ecom-ex.com' => 'Alexander Maertens'])
                ->setSubject($this->settings['mail']['receiverSubject'] ?: LocalizationUtility::translate('mail_subject_generic',
                        $this->extensionName) . LocalizationUtility::translate('mail_subject_new',
                        $this->extensionName))
                ->setBody($this->getStandAloneTemplate('Email/SubscriptionReceived', [
                    'subscription' => $subscription,
                    'marketingInformation' => SessionUtility::getMarketingInfos()
                ]))
                ->send();
            // If link has expired
        } elseif ($subscription instanceof \S3b0\EcomNewsletterSubscription\Domain\Model\Subscription) {
            $this->forward('new', null, null, [
                'newSubscription' => null,
                'dismissibleAlert' => $this->getStandAloneTemplate('Notifications/LinkExpired')
            ]);
            // If email was already confirmed
        } elseif ($subscription = $this->subscriptionRepository->findConfirmedByHashAndEmail($hash, $email)) {
            $this->forward('new', null, null, [
                'newSubscription' => null,
                'dismissibleAlert' => $this->getStandAloneTemplate('Notifications/AlreadyConfirmed')
            ]);
        } else {
            $this->redirectToUri($this->uriBuilder->reset()->build());
        }
    }

    /**
     * action delete
     *
     * @param string $hash
     * @param string $email
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     */
    public function deleteAction($hash, $email)
    {
        /** @var \S3b0\EcomNewsletterSubscription\Domain\Model\Subscription $subscription */
        $subscription = $this->subscriptionRepository->findUnconfirmedByHashAndEmail($hash, $email);

        // If subscription was found
        if ($subscription instanceof \S3b0\EcomNewsletterSubscription\Domain\Model\Subscription) {
            $this->deleteRecord($subscription);
            /** @var \TYPO3\CMS\Core\Mail\MailMessage $mailToSender */
            $mailToSender = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
            $mailToSender->setContentType('text/html');

            // Email to sender
            $mailToSender->setFrom($this->noReplyEmailAddresses ?: $this->senderEmailAddresses)
                ->setTo([$subscription->getEmail() => $subscription->getName()])
                ->setSubject($this->settings['mail']['senderSubject'] ?: LocalizationUtility::translate('mail_subject_generic',
                        $this->extensionName) . LocalizationUtility::translate('mail_subject_deleted',
                        $this->extensionName))
                ->setBody($this->getStandAloneTemplate('Email/EmailDeleted', [
                    'subscription' => $subscription
                ]))
                ->send();

            $this->view->assign('subscription', $subscription);
        } else {
            $this->redirectToUri($this->uriBuilder->reset()->build());
        }
    }

    /**
     * Initializes the controller before invoking resendActivationMailAction method.
     *
     * @return void
     */
    public function initializeResendActivationMailAction()
    {
        // Since enableField 'hidden' is used for activation, unconfirmed (not activated) records won't be found with TYPO3 defaults.
        // So we do this manually by using argument uid for fetching correspondent record.
        if ($this->request->hasArgument('subscription')) {
            $this->request->setArgument('subscription',
                $this->subscriptionRepository->findByUid((int)$this->request->getArgument('subscription')));
        }
    }

    /**
     * action resendActivationMail
     *
     * @param \S3b0\EcomNewsletterSubscription\Domain\Model\Subscription $subscription
     * @return void
     */
    public function resendActivationMailAction(\S3b0\EcomNewsletterSubscription\Domain\Model\Subscription $subscription)
    {
        /** @var \TYPO3\CMS\Core\Mail\MailMessage $mailToSender */
        $mailToSender = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
        $mailToSender->setContentType('text/html');

        // Email to sender
        $mailToSender->setFrom($this->noReplyEmailAddresses ?: $this->senderEmailAddresses)
            ->setTo([$subscription->getEmail() => $subscription->getName()])
            ->setSubject($this->settings['mail']['senderSubject'] ?: LocalizationUtility::translate('mail_subject_generic',
                    $this->extensionName) . LocalizationUtility::translate('mail_subject_new', $this->extensionName))
            ->setBody($this->getStandAloneTemplate('Email/EmailSubscribed', [
                'subscription' => $subscription
            ]))
            ->send();

        $this->view->assign('subscription', $subscription);
    }

    /**
     * @param string $templateName template name (UpperCamelCase)
     * @param array $variables variables to be passed to the Fluid view
     *
     * @return string
     */
    protected function getStandAloneTemplate($templateName, array $variables = [])
    {
        /** @var \TYPO3\CMS\Fluid\View\StandaloneView $view */
        $view = $this->objectManager->get(\TYPO3\CMS\Fluid\View\StandaloneView::class);
        // Attach settings to variables
        $variables['settings'] = $this->settings;

        $relativePath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::siteRelPath(GeneralUtility::camelCaseToLowerCaseUnderscored($this->extensionName));
        $layoutRootPath = "{$relativePath}Resources/Private/Layouts/";
        $templateRootPath = "{$relativePath}Resources/Private/Templates/";
        $partialRootPath = "{$relativePath}Resources/Private/Partials/";
        $templatePathAndFilename = "{$templateRootPath}{$templateName}.html";
        $view->setControllerContext($this->controllerContext);
        $view->setLayoutRootPaths([$layoutRootPath]);
        $view->setPartialRootPaths([$partialRootPath]);
        $view->setTemplatePathAndFilename($templatePathAndFilename);
        $view->assignMultiple($variables);
        $view->setFormat('html');

        return \Ecom\EcomToolbox\Utility\Div::sanitize_output($view->render());
    }

}
