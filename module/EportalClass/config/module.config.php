<?php

return [
    'controllers' => [
        'factories' => [
            'EportalClass\Controller\EportalClass' => \EportalClass\Factory\EportalClassControllerFactory::class,
        ],
        'invokables' => [
            'EportalClass\Controller\EportalClassUser' => \EportalClass\Controller\EportalClassUserController::class,
            'EportalClass\Controller\EportalClassData' => \EportalClass\Controller\EportalClassData::class
        ]
    ],
    'router' => [
        'routes' => [
            'zfcadmin' => [
                'child_routes' => [
                    'eportal-class' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/class[/:action]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                            'defaults' => [
                                '__NAMESPACE__' => 'EportalClass\Controller',
                                'controller' => 'EportalClass',
                                'action' => 'index',
                                'property' => 'class'
                            ],
                        ],
                    ],
                    'eportal-class-user' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/class-user[/:user][/:action]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'user' => 'student|teacher',
                            ],
                            'defaults' => [
                                '__NAMESPACE__' => 'EportalClass\Controller',
                                'controller' => 'EportalClassUser',
                                'action' => 'index',
                                'property' => 'class'
                            ],
                        ],
                    ],
                ]
            ],
            'data' => [
                'child_routes' => [
                    'eportal-class' => [
                        'type' => 'segment',
                        'options' => [
                            'route' => '/class[/:action]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                            'defaults' => [
                                'controller' => 'EportalClass\Controller\EportalClassData'
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            'EportalClass\Service\EportalClass' => \EportalClass\Factory\EportalClassServiceFactory::class,
            'EportalClass\Mapper\EportalClass' => \EportalClass\Factory\EportalClassMapperFactory::class,
            'EportalClass\Service\EportalClassUser' => \EportalClass\Factory\EportalClassUserServiceFactory::class,
            'EportalClass\Mapper\EportalClassUser' => \EportalClass\Factory\EportalClassUserMapperFactory::class
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            'EportalClass' => __DIR__ . '/../view',
        ],
        'strategies' => [
            'ViewJsonStrategy',
        ]
    ],
    'bjyauthorize' => [
        'guards' => [
            \BjyAuthorize\Guard\Route::class => [
                ['route' => 'zfcadmin/eportal-class', 'roles' => []],
                ['route' => 'zfcadmin/eportal-class-user', 'roles' => []],
                ['route' => 'data/eportal-class', 'roles' => []]
            ]
        ]
    ]
];
