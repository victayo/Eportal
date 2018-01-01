<?php

return [
    'router' => [
        'routes' => [
            'zfcadmin' => [
                'child_routes' => [
                    'property' => [
                        'type' => 'segment',
                        'options' => [
                            'route' => '/property[/:action]',
                            'defaults' => [
                                'controller' => 'EportalProperty\Controller\EportalProperty',
                                'action' => 'index'
                            ],
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                            ]
                        ],
                    ],
                    'property-user' => [
                        'type' => 'segment',
                        'options' => [
                            'route' => '/property-user[/:action]',
                            'defaults' => [
                                'controller' => 'EportalProperty\Controller\EportalPropertyUser',
                                'action' => 'index'
                            ],
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                            ]
                        ],
                    ]
                ]
            ],
            'api' => [
                'child_routes' => [
                    'property' => [
                        'type' => 'segment',
                        'options' => [
                            'route' => '/property[/:id]',
                            'constraints' => [
                                'id' => '[0-9]+'
                            ],
                            'defaults' => [
                                'controller' => 'EportalProperty\Controller\EportalPropertyAPI'
                            ]
                        ]
                    ]
                ]
            ],
            'data' => [
                'child_routes' => [
                    'property' => [
                        'type' => 'segment',
                        'options' => [
                            'route' => '/property[/:action]',
                            'contraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                            ],
                            'defaults' => [
                                'controller' => 'EportalProperty\Controller\EportalPropertyData'
                            ]
                        ]
                    ]
                ]
            ]
        ],
    ],
    'controllers' => [
        'invokables' => [
            'EportalProperty\Controller\EportalProperty' => \EportalProperty\Controller\EportalPropertyController::class,
            'EportalProperty\Controller\EportalPropertyUser' => \EportalProperty\Controller\EportalPropertyUserController::class,
            'EportalProperty\Controller\EportalPropertyAPI' => \EportalProperty\Controller\EportalPropertyAPI::class,
            'EportalProperty\Controller\EportalPropertyData' => \EportalProperty\Controller\EportalPropertyData::class
        ]
    ],
    'service_manager' => [
        'factories' => [
            'EportalProperty\Mapper\EportalPropertyUser' => \EportalProperty\Factory\EportalPropertyUserMapperFactory::class,
            'EportalProperty\Service\EportalPropertyUser' => \EportalProperty\Factory\EportalPropertyUserServiceFactory::class
        ]
    ],
    'controller_plugins' => [
        'invokables' => [
            'PropertyValueSaver' => 'EportalProperty\Controller\Plugin\PropertyValueSaverPlugin',
            'Property' => \EportalProperty\Controller\Plugin\PropertyPlugin::class,
            'PropertyValue' => \EportalProperty\Controller\Plugin\PropertyValuePlugin::class
        ]
    ],
    'view_manager' => [
        'template_path_stack' => ['EportalProperty' => __DIR__ . '/../view',],
        'strategies' => ['ViewJsonStrategy',]
    ],
    'form_elements' => [
        'invokables' => [
            'EportalProperty\Fieldset\EportalProperty' => 'EportalProperty\Form\EportalPropertyFieldset',
            'EportalProperty\Form\EportalProperty' => 'EportalProperty\Form\EportalPropertyForm',
        ]
    ],
    'bjyauthorize' => [
        'guards' => [
            \BjyAuthorize\Guard\Route::class => [
                ['route' => 'zfcadmin/property', 'roles' => []],
                ['route' => 'zfcadmin/property-user', 'roles' => []],
                ['route' => 'api/property', 'roles' => []],
                ['route' => 'data/property', 'roles' => []],
            ]
        ]
    ]
];
