<?php

return [
    'router' => [
        'routes' => [
            'zfcadmin' => [
                'child_routes' => [
                    'setting' => [
                        'type' => 'segment',
                        'options' => [
                            'route' => '/setting[/:action]',
                            'defaults' => [
                                'controller' => 'EportalSetting\Controller\EportalSetting',
                                'action' => 'index',
                            ],
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                            ]
                        ]
                    ]
                ]
            ]
        ],
    ],
    'controllers' => [
        'invokables' => [
            'EportalSetting\Controller\EportalSetting' => \EportalSetting\Controller\EportalSettingController::class
        ]
    ],
    'controller_plugins' => [
        'invokables' => [
            'SaveSetting' => \EportalSetting\Controller\Plugin\EportalSettingSaverPlugin::class,
        ]
    ],
    'service_manager' => [
        'factories' => [
            'EportalSetting\Mapper\EportalSetting' => \EportalSetting\Factory\Mapper\EportalSettingMapperFactory::class,
            'EportalSetting\Service\EportalSetting' => \EportalSetting\Factory\Service\EportalSettingServiceFactory::class,
        ]
    ],
    'form_elements' => [
        'invokables' => [
            'EportalSetting\Fieldset\EportalSetting' => \EportalSetting\Form\EportalSettingFieldset::class,
            'EportalSetting\Form\EportalSetting' => \EportalSetting\Form\EportalSettingForm::class
        ]
    ],
    'view_manager' => [
        'template_path_stack' => ['EportalSetting' => __DIR__ . '/../view',],
        'strategies' => ['ViewJsonStrategy',]
    ],
    
    'bjyauthorize' => [
        'guards' => [
            \BjyAuthorize\Guard\Route::class => [
                ['route' => 'zfcadmin/setting', 'roles' => []]
            ]
        ]
    ]
];
