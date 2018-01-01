<?php

return [
    'controllers' => [
        'factories' => [
            'EportalSchool\Controller\EportalSchool' => \EportalSchool\Factory\EportalSchoolControllerFactory::class,
        ],
        'invokables' => [
            'EportalSchool\Controller\EportalSchoolUser' => \EportalSchool\Controller\EportalSchoolUserController::class,
            'EportalSchool\Controller\EportalSchoolData' => \EportalSchool\Controller\EportalSchoolData::class
        ]
    ],
    'router' => [
        'routes' => [
            'zfcadmin' => [
                'child_routes' => [
                    'eportal-school' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/school[/:action]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                            'defaults' => [
                                '__NAMESPACE__' => 'EportalSchool\Controller',
                                'controller' => 'EportalSchool',
                                'action' => 'index',
                                'property' => 'school'
                            ],
                        ],
                    ],
                    'eportal-school-user' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/school-user[/:user][/:action]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                            'defaults' => [
                                '__NAMESPACE__' => 'EportalSchool\Controller',
                                'controller' => 'EportalSchoolUser',
                                'action' => 'index',
                            ],
                        ],
                    ],
                ]
            ],
            'data' => [
                'child_routes' => [
                    'eportal-school' => [
                        'type' => 'segment',
                        'options' => [
                            'route' => '/school[/:action]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                            'defaults' => [
                                'controller' => 'EportalSchool\Controller\EportalSchoolData'
                            ]
                        ]
                    ]
                ]
            ]
        ],
    ],
    'service_manager' => [
        'factories' => [
            'EportalSchool\Service\EportalSchool' => \EportalSchool\Factory\EportalSchoolServiceFactory::class,
            'EportalSchool\Mapper\EportalSchool' => \EportalSchool\Factory\EportalSchoolMapperFactory::class,
            'EportalSchool\Service\EportalSchoolUser' => \EportalSchool\Factory\EportalSchoolUserServiceFactory::class,
            'EportalSchool\Mapper\EportalSchoolUser' => \EportalSchool\Factory\EportalSchoolUserMapperFactory::class
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            'EportalSchool' => __DIR__ . '/../view',
        ],
        'strategies' => [
            'ViewJsonStrategy',
        ]
    ],
    'bjyauthorize' => [
        'guards' => [
            \BjyAuthorize\Guard\Route::class => [
                ['route' => 'zfcadmin/eportal-school', 'roles' => []],
                ['route' => 'zfcadmin/eportal-school-user', 'roles' => []],
                ['route' => 'data/eportal-school', 'roles' => []]
            ]
        ]
    ]
];
