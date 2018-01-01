<?php

return [
    'controllers' => [
        'factories' => [
            'EportalTerm\Controller\EportalTerm' => \EportalTerm\Factory\EportalTermControllerFactory::class
        ],
    ],
    'router' => [
        'routes' => [
            'zfcadmin' => [
                'child_routes' => [
                    'eportal-term' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/term[/:action]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                            'defaults' => [
                                '__NAMESPACE__' => 'EportalTerm\Controller',
                                'controller' => 'EportalTerm',
                                'action' => 'index',
                                'property' => 'term'
                            ],
                        ],
                    ],
                ]
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            'EportalTerm\Service\EportalTerm' => \EportalTerm\Factory\EportalTermServiceFactory::class,
            'EportalTerm\Mapper\EportalTerm' => \EportalTerm\Factory\EportalTermMapperFactory::class
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            'EportalTerm' => __DIR__ . '/../view',
        ],
    ],
    'bjyauthorize' => [
        'guards' => [
            \BjyAuthorize\Guard\Route::class => [
                ['route' => 'zfcadmin/eportal-term', 'roles' => []]
            ]
        ]
    ]
];
