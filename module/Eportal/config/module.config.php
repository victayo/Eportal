<?php

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => [
                    'route' => '/',
                    'defaults' => [
                        'controller' => 'Eportal\Controller\Eportal',
                        'action' => 'index',
                    ],
                ],
            ],
            'student' => [
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => [
                    'route' => '/student[/:action]',
                    'defaults' => [
                        'controller' => 'Eportal\Controller\Student',
                        'action' => 'index',
                    ],
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ]
                ],
            ],
            'api' => [
                'type' => 'literal',
                'options' => [
                    'route' => '/api'
                ],
                'may_terminate' => false,
            ],
            'data' => [
                'type' => 'literal',
                'options' => [
                    'route' => '/data'
                ],
                'may_terminate' => false
            ]
        ],
    ],
    'service_manager' => [
        'invokables' => [
            'Eportal\Service\Util' => 'Eportal\Service\EportalUtil'
        ],
        'factories' => [
            'navigation' => \Zend\Navigation\Service\DefaultNavigationFactory::class,
        ],
        'abstract_factories' => [
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ],
        'aliases' => [
            'translator' => 'MvcTranslator',
        ],
    ],
    'controllers' => [
        'invokables' => [
            'Eportal\Controller\Eportal' => 'Eportal\Controller\EportalController',
        ],
        'factories' => [
            'Eportal\Controller\Student' => \Eportal\Factory\Controller\StudentControllerFactory::class
        ]
    ],
    'translator' => [
        'locale' => 'en_US',
        'translation_file_patterns' => [
            [
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo',
            ],
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => [
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'eportal/eportal/index' => __DIR__ . '/../view/eportal/eportal/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            'Eportal' => __DIR__ . '/../view',
        ],
    ],
    'navigation' => [
        'default' => [
            [
                'label' => 'Home',
                'route' => 'home',
            ],
            [
                'label' => 'Admin',
                'route' => 'zfcadmin',
                'pages' => [
                    [
                        'label' => 'User',
                        'route' => 'zfcadmin/user'
                    ]
                ]
            ]
        ]
    ],
    'bjyauthorize' => [
        'guards' => [
            \BjyAuthorize\Guard\Route::class => [
                ['route' => 'home', 'roles' => []],
                ['route' => 'zfcuser', 'roles' => []],
                ['route' => 'zfcuser/login', 'roles' => []],
                ['route' => 'zfcuser/logout', 'roles' => []],
                ['route' => 'student', 'roles' => []],
            ],
        ]
    ]
];
