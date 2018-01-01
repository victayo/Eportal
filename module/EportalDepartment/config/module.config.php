<?php

return [
    'controllers' => [
        'factories' => [
            'EportalDepartment\Controller\EportalDepartment' => \EportalDepartment\Factory\EportalDepartmentControllerFactory::class,
        ],
        'invokables' => [
            'EportalDepartment\Controller\EportalDepartmentUser' => \EportalDepartment\Controller\EportalDepartmentUserController::class,
            'EportalDepartment\Controller\EportalDepartmentData' => \EportalDepartment\Controller\EportalDepartmentData::class
        ],
    ],
    'router' => [
        'routes' => [
            'zfcadmin' => [
                'child_routes' => [
                    'eportal-department' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/department[/:action]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                            'defaults' => [
                                '__NAMESPACE__' => 'EportalDepartment\Controller',
                                'controller' => 'EportalDepartment',
                                'action' => 'index',
                                'property' => 'department'
                            ],
                        ],
                    ],
                    'eportal-department-user' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/department-user[/:user][/:action]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                            'defaults' => [
                                '__NAMESPACE__' => 'EportalDepartment\Controller',
                                'controller' => 'EportalDepartmentUser',
                                'action' => 'index',
                            ],
                        ],
                    ],
                ]
            ],
            'data' => [
                'child_routes' => [
                    'eportal-department' => [
                        'type' => 'segment',
                        'options' => [
                            'route' => '/department[/:action]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                            'defaults' => [
                                'controller' => 'EportalDepartment\Controller\EportalDepartmentData'
                            ]
                        ]
                    ]
                ]
            ]
        ],
    ],
    'service_manager' => [
        'factories' => [
            'EportalDepartment\Service\EportalDepartment' => \EportalDepartment\Factory\EportalDepartmentServiceFactory::class,
            'EportalDepartment\Mapper\EportalDepartment' => \EportalDepartment\Factory\EportalDepartmentMapperFactory::class,
            'EportalDepartment\Service\EportalDepartmentUser' => \EportalDepartment\Factory\EportalDepartmentUserServiceFactory::class,
            'EportalDepartment\Mapper\EportalDepartmentUser' => \EportalDepartment\Factory\EportalDepartmentUserMapperFactory::class
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            'EportalDepartment' => __DIR__ . '/../view',
        ],
        'strategies' => [
            'ViewJsonStrategy',
        ]
    ],
    'bjyauthorize' => [
        'guards' => [
            \BjyAuthorize\Guard\Route::class => [
                ['route' => 'zfcadmin/eportal-department', 'roles' => []],
                ['route' => 'zfcadmin/eportal-department-user', 'roles' => []],
                ['route' => 'data/eportal-department', 'roles' => []]
            ]
        ]
    ]
];
