<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'S3b0.EcomNewsletterSubscription',
	'NewsletterSubscription',
	[
		'Subscription' => 'new, create, confirm, delete, resendActivationMail'
	],
	// non-cacheable actions
	[
		'Subscription' => 'new, create, confirm, delete, resendActivationMail'
	]
);