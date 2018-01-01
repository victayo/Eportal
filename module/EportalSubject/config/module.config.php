<?php

return [
    'controllers' => [
        'factories' => [
            'EportalSubject\Controller\EportalSubject' => \EportalSubject\Factory\EportalSubjectControllerFactory::class
        ],
        'invokables' => [
            'EportalSubject\Controller\EportalSubjectUser' => \EportalSubject\Controller\EportalSubjectUserController::class
        ]
    ],
    'router' => [
        'routes' => [
            'zfcadmin' => [
                'child_routes' => [
                    'eportal-subject' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/subject[/:action]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                            'defaults' => [
                                '__NAMESPACE__' => 'EportalSubject\Controller',
                                'controller' => 'EportalSubject',
                                'action' => 'index',
                                'property' => 'subject'
                            ],
                        ],
                    ],
                    'eportal-subject-user' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/subject-user[/:user][/:action]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                            'defaults' => [
                                '__NAMESPACE__' => 'EportalSubject\Controller',
                                'controller' => 'EportalSubjectUser',
                                'action' => 'index',
                                'property' => 'subject',
                            ],
                        ],
                    ],
                ]
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            'EportalSubject\Service\EportalSubject' => \EportalSubject\Factory\EportalSubjectServiceFactory::class,
            'EportalSubject\Mapper\EportalSubject' => \EportalSubject\Factory\EportalSubjectMapperFactory::class,
            'EportalSubject\Service\EportalSubjectUser' => \EportalSubject\Factory\EportalSubjectUserServiceFactory::class,
            'EportalSubject\Mapper\EportalSubjectUser' => \EportalSubject\Factory\EportalSubjectUserMapperFactory::class
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            'EportalSubject' => __DIR__ . '/../view',
        ],
    ],
    'bjyauthorize' => [
        'guards' => [
            \BjyAuthorize\Guard\Route::class => [
                ['route' => 'zfcadmin/eportal-subject', 'roles' => []],
                ['route' => 'zfcadmin/eportal-subject-user', 'roles' => []]
            ]
        ]
    ]
];
