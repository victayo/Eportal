<?php

return [
    'router' => [
        'routes' => [
            'zfcadmin' => [
                'child_routes' => [
                    'user' => [
                        'type' => 'literal',
                        'options' => [
                            'route' => '/user',
                            'defaults' => [
                                'controller' => 'EportalUser\Controller\EportalUser',
                                'action' => 'index'
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'edit' => [
                                'type' => 'literal',
                                'options' => [
                                    'route' => '/edit',
                                    'defaults' => [
                                        'controller' => 'EportalUser\Controller\Edit',
                                        'action' => 'index'
                                    ],
                                ]
                            ],
                            'list' => [
                                'type' => 'segment',
                                'options' => [
                                    'route' => '/list[/:user]',
                                    'defaults' => [
                                        'controller' => 'EportalUser\Controller\List',
                                        'action' => 'index'
                                    ],
                                    'constraints' => [
                                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                        'user' => 'student|teacher'
                                    ]
                                ]
                            ],
                            'property' => [
                                'type' => 'segment',
                                'options' => [
                                    'route' => '/property[/:action]',
                                    'defaults' => [
                                        'controller' => 'EportalUser\Controller\EportalPropertyUser',
                                        'action' => 'index'
                                    ],
                                    'constraints' => [
                                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                                    ]
                                ]
                            ],
                            'register' => [
                                'type' => 'segment',
                                'options' => [
                                    'route' => '/register[/:user][/:action]',
                                    'defaults' => [
                                        'controller' => 'EportalUser\Controller\Register',
                                        'action' => 'index',
                                    ],
                                    'constraints' => [
                                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                        'user' => 'student|teacher'
                                    ]
                                ],
                            ],
                            'view' => [
                                'type' => 'segment',
                                'options' => [
                                    'route' => '/view[/:id]',
                                    'defaults' => [
                                        'controller' => 'EportalUser\Controller\View',
                                        'action' => 'index',
                                    ],
                                    'constraints' => [
                                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                        'id' => '[0-9]+'
                                    ]
                                ],
                            ],
                        ],
                    ],
                ]
            ]
        ]
    ],
    'form_elements' => [
        'invokables' => [
            'EportalUser\Fieldset\Register' => 'EportalUser\Form\EportalRegistrationFieldset',
            'EportalUser\Form\Register' => 'EportalUser\Form\EportalRegistrationForm',
            'EportalUser\Fieldset\UserUpload' => 'EportalUser\Form\UserUploadFieldset',
            'EportalUser\Form\UserUpload' => 'EportalUser\Form\UserUploadForm',
            'EportalUser\Form\User' => \EportalUser\Form\EportalUserForm::class,
        ],
    ],
    'service_manager' => [
        'invokables' => [
            'EportalUser\Form\EportalUser' => \EportalUser\Form\EportalUserForm::class,
            'EportalUser\Service\Util' => \EportalUser\Service\EportalUserUtilService::class,
            'EportalUser\Form\EportalUser' => 'EportalUser\Form\EportalUserForm',
            'EportalUser\Hydrator' => \ZfcUser\Mapper\UserHydrator::class
        ],
        'factories' => [
            'EportalUser\Service\EportalUser' => \EportalUser\Factory\Service\EportalUserServiceFactory::class,
            'EportalUser\Service\UserPropertyValue' => \EportalUser\Factory\Service\UserPropertyValueServiceFactory::class,
            'EportalUser\Service\UserSessionTerm' => \EportalUser\Factory\Service\UserSessionTermServiceFactory::class,
            'EportalUser\Service\RelUserPropertyValue' => \EportalUser\Factory\Service\RelUserPropertyValueServiceFactory::class,
            'EportalUser\Mapper\EportalUser' => \EportalUser\Factory\Mapper\EportalUserMapperFactory::class,
            'EportalUser\Mapper\UserPropertyValue' => \EportalUser\Factory\Mapper\UserPropertyValueMapperFactory::class,
            'EportalUser\Mapper\UserSessionTerm' => \EportalUser\Factory\Mapper\UserSessionTermMapperFactory::class,
            'EportalUser\Mapper\RelUserPropertyValue' => \EportalUser\Factory\Mapper\RelUserPropertyValueMapperFactory::class,
            'zfc_user_mapper' => \EportalUser\Factory\Mapper\EportalUserMapperFactory::class,
        ]
    ],
    'controllers' => [
        'invokables' => [
//            'EportalUser\Controller\EportalUser' => 'EportalUser\Controller\EportalUserController',
            'EportalUser\Controller\Student' => 'EportalUser\Controller\Student\StudentController',
            'EportalUser\Controller\Student\Register' => 'EportalUser\Controller\Student\RegisterController',
            'EportalUser\Controller\Student\List' => 'EportalUser\Controller\Student\ListController',
            'EportalUser\Controller\EportalPropertyUser' => 'EportalUser\Controller\EportalPropertyUserController',
            'EportalUser\Controller\Teacher' => 'EportalUser\Controller\Teacher\TeacherController',
            'EportalUser\Controller\Teacher\Register' => 'EportalUser\Controller\Teacher\RegisterController',
            'EportalUser\Controller\\List' => 'EportalUser\Controller\ListController',
            'EportalUser\Controller\Edit' => 'EportalUser\Controller\EditController',
            'EportalUser\Controller\View' => 'EportalUser\Controller\ViewController',
            'EportalUser\Controller\Register' => 'EportalUser\Controller\RegisterController',
        ],
        'factories' => [
            'EportalUser\Controller\EportalUser' => \EportalUser\Factory\Controller\EportalUserControllerFactory::class,
        ]
    ],
    'controller_plugins' => [
        'invokables' => [
            'SaveUser' => 'EportalUser\Controller\Plugin\SaveUserPlugin',
            'saveMultipleUsers' => 'EportalUser\Controller\Plugin\SaveMultipleUsers'
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            'EportalUser' => __DIR__ . '/../view',
        ],
        'strategies' => [
            'ViewJsonStrategy',
        ]
    ],
    'bjyauthorize' => [
        'guards' => [
            \BjyAuthorize\Guard\Route::class => [
                ['route' => 'zfcadmin/user', 'roles' => []],
                ['route' => 'zfcadmin/user/view', 'roles' => []],
                ['route' => 'zfcadmin/user/edit', 'roles' => []],
                ['route' => 'zfcadmin/user/list', 'roles' => []],
                ['route' => 'zfcadmin/user/register', 'roles' => []],
                ['route' => 'zfcadmin/user/register/student', 'roles' => []],
                ['route' => 'zfcadmin/user/register/teacher', 'roles' => []],
                ['route' => 'zfcadmin/user/property', 'roles' => []],
            ],
        ],
    ]
];
