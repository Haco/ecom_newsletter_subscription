<?php

$EM_CONF[$_EXTKEY] = [
	'title' => 'Newsletter subscription',
	'description' => 'ecom newsletter subscription',
	'category' => 'plugin',
	'author' => 'Sebastian Iffland',
	'author_email' => 'Sebastian.Iffland@ecom-ex.com',
	'state' => 'stable',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'clearCacheOnLoad' => 0,
	'version' => '1.0.2',
	'constraints' => [
		'depends' => [
			'cms' => '',
			'typo3' => '7.6',
			'php' => '5.6',
			'ecom_toolbox' => ''
		],
		'conflicts' => [
		],
		'suggests' => [
		]
	],
];