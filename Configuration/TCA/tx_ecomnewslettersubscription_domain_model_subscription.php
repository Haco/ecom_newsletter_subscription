<?php
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

$localLang = 'LLL:EXT:ecom_newsletter_subscription/Resources/Private/Language/locallang_db.xlf:tx_ecomnewslettersubscription_domain_model_subscription.';

return [
    'ctrl' => [
        'label' => 'name',
        'label_alt' => 'email',
        'default_sortby' => 'ORDER BY name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => true,
        'readOnly' => true,
        'rootLevel' => 1,
        'prependAtCopy' => 'LLL:EXT:lang/locallang_general.xlf:LGL.prependAtCopy',
        'delete' => 'deleted',
        'title' => 'LLL:EXT:ecom_newsletter_subscription/Resources/Private/Language/locallang_db.xlf:tx_ecomnewslettersubscription_domain_model_subscription',
        'thumbnail' => 'image',
        'enablecolumns' => [
            'disabled' => 'hidden'
        ],
        'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('ecom_newsletter_subscription') . 'ext_icon.gif',
        'searchFields' => 'name, first_name, middle_name, last_name, email'
    ],
    'interface' => [
        'showRecordFieldList' => 'name,address,building,room,city,zip,region,country,phone,fax,email,www,title,company,image'
    ],
    'feInterface' => [
        'fe_admin_fieldList' => 'pid,hidden,gender,name,title,address,building,room,birthday,phone,fax,mobile,www,email,city,zip,company,region,country,image,description'
    ],
    'columns' => [
        'hidden' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check'
            ]
        ],
        'gender' => [
            'label' => "{$localLang}gender",
            'config' => [
                'type' => 'radio',
                'default' => 0,
                'items' => [
                    ["{$localLang}gender.0", 0],
                    ["{$localLang}gender.1", 1]
                ]
            ]
        ],
        'name' => [
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.name',
            'config' => [
                'type' => 'input',
                'size' => 40,
                'eval' => 'trim,required',
                'max' => 255
            ]
        ],
        'first_name' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.first_name',
            'config' => [
                'type' => 'input',
                'size' => 40,
                'eval' => 'trim',
                'max' => 255
            ]
        ],
        'middle_name' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.middle_name',
            'config' => [
                'type' => 'input',
                'size' => 40,
                'eval' => 'trim',
                'max' => 255
            ]
        ],
        'last_name' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.last_name',
            'config' => [
                'type' => 'input',
                'size' => 40,
                'eval' => 'trim',
                'max' => 255
            ]
        ],
        'birthday' => [
            'exclude' => 1,
            'label' => "{$localLang}birthday",
            'config' => [
                'type' => 'input',
                'size' => 8,
                'eval' => 'date',
                'max' => 20
            ]
        ],
        'title' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.title_person',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'max' => 255
            ]
        ],
        'address' => [
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.address',
            'config' => [
                'type' => 'text',
                'cols' => 20,
                'rows' => 3
            ]
        ],
        'building' => [
            'label' => "{$localLang}building",
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'max' => 20
            ]
        ],
        'room' => [
            'label' => "{$localLang}room",
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'max' => 15
            ]
        ],
        'phone' => [
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.phone',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'max' => 50
            ]
        ],
        'fax' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.fax',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'max' => 50
            ]
        ],
        'mobile' => [
            'exclude' => 1,
            'label' => "{$localLang}mobile",
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'max' => 50
            ]
        ],
        'www' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.www',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'max' => 255,
                'wizards' => [
                    'link' => [
                        'type' => 'popup',
                        'title' => 'LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.link',
                        'icon' => 'EXT:backend/Resources/Public/Images/FormFieldWizard/wizard_link.gif',
                        'module' => [
                            'name' => 'wizard_link',
                        ],
                        'params' => [
                            'blindLinkOptions' => 'mail,file,spec,folder',
                        ],
                        'JSopenParams' => 'width=800,height=600,status=0,menubar=0,scrollbars=1'
                    ]
                ]
            ]
        ],
        'email' => [
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.email',
            'config' => [
                'type' => 'input',
                'size' => 40,
                'eval' => 'trim,required,email',
                'max' => 255
            ]
        ],
        'company' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.company',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim,required',
                'max' => 255
            ]
        ],
        'city' => [
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.city',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'max' => 255
            ]
        ],
        'zip' => [
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.zip',
            'config' => [
                'type' => 'input',
                'size' => 10,
                'eval' => 'trim',
                'max' => 20
            ]
        ],
        'state' => [
            'displayCond' => 'FIELD:country:REQ:TRUE',
            'exclude' => 1,
            'label' => "{$localLang}state",
            'config' => [
                'type' => 'select',
                'items' => [['', 0]],
                'foreign_table' => 'tx_ecomtoolbox_domain_model_state',
                'foreign_table_where' => 'AND tx_ecomtoolbox_domain_model_state.sys_language_uid IN (-1,0) AND tx_ecomtoolbox_domain_model_state.country=###REC_FIELD_country###',
                'minitems' => 0,
                'maxitems' => 1
            ]
        ],
        'country' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.country',
            'config' => [
                'type' => 'select',
                'items' => [['', 0]],
                'foreign_table' => 'tx_ecomtoolbox_domain_model_region',
                'foreign_table_where' => 'AND tx_ecomtoolbox_domain_model_region.sys_language_uid IN (-1,0) AND tx_ecomtoolbox_domain_model_region.type=0 AND NOT tx_ecomtoolbox_domain_model_region.deleted ORDER BY tx_ecomtoolbox_domain_model_region.title',
                'minitems' => 0,
                'maxitems' => 1
            ]
        ],
        'image' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.image',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'image',
                ['maxitems' => 1],
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            )
        ],
        'description' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.description',
            'config' => [
                'type' => 'text',
                'rows' => 5,
                'cols' => 48
            ]
        ],
        'hash' => [
            'exclude' => 1,
            'label' => "{$localLang}hash",
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'max' => 255
            ]
        ]
    ],
    'types' => [
        '1' => ['showitem' => 'hidden;;;;1-1-1, gender;;;;3-3-3, name, title, company, birthday, address, building, room, zip, city, country, state, email, www, phone, fax, mobile, image;;;;4-4-4, description, hash']
    ],
    'palettes' => [
        '2' => ['showitem' => 'title, company'],
        '3' => ['showitem' => 'country, state'],
        '4' => ['showitem' => 'mobile, fax'],
        '5' => ['showitem' => 'www'],
        '6' => ['showitem' => 'building, room']
    ]
];
