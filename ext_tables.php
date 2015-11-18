<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

  // Add static templates
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('ecom_newsletter_subscription', 'Resources/Private/TypoScript', 'Newsletter subscription');

  // Tables allowed on regular TYPO3 pages
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_ecomnewslettersubscription_domain_model_subscription');