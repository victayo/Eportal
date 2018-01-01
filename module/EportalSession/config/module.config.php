<?php

return [
    'controllers' => [
        'factories' => [
            'EportalSession\Controller\EportalSession' => \EportalSession\Factory\EportalSessionControllerFactory::class,
        ],
        'invokables' => [
            'EportalSession\Controller\EportalSessionUser' => \EportalSession\Controller\EportalSessionUserController::class,
        ],
    ],
    'router' => [
        'routes' => [
            'zfcadmin' => [
                'child_routes' => [
                    'eportal-session' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/session[/:action]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                            'defaults' => [
                                '__NAMESPACE__' => 'EportalSession\Controller',
                                'controller' => 'EportalSession',
                                'action' => 'index',
                                'property' => 'session'
                            ],
                        ],
                    ],
                    'eportal-session-user' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/session-user[/:user][/:action]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                            'defaults' => [
                                '__NAMESPACE__' => 'EportalSession\Controller',
                                'controller' => 'EportalSessionUser',
                                'action' => 'index',
                            ],
                        ],
                    ],
                ]
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            'EportalSession\Service\EportalSession' => \EportalSession\Factory\EportalSessionServiceFactory::class,
            'EportalSession\Mapper\EportalSession' => \EportalSession\Factory\EportalSessionMapperFactory::class
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            'EportalSession' => __DIR__ . '/../view',
        ],
        'strategies' => [
            'ViewJsonStrategy',
        ]
    ],
    'bjyauthorize' => [
        'guards' => [
            \BjyAuthorize\Guard\Route::class => [
                ['route' => 'zfcadmin/eportal-session', 'roles' => []],
                ['route' => 'zfcadmin/eportal-session-user', 'roles' => []]
            ]
        ]
    ]
];
