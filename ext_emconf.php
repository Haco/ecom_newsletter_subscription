<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Newsletter subscription',
    'description' => 'ecom newsletter subscription',
    'category' => 'plugin',
    'author' => 'Nicolas Scheidler, Sebastian Iffland',
    'author_email' => 'Nicolas.Scheidler@ecom-ex.com',
    'state' => 'stable',
    'internal' => '',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '1.0.12',
    'constraints' => [
        'depends' => [
            'cms' => '',
            'typo3' => '7.6-7.6.99',
            'ecom_toolbox' => ''
        ],
        'conflicts' => [
        ],
        'suggests' => [
        ]
    ],
];
