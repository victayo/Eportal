<?php

return [
    'router' => [
        'routes' => [
            'zfcadmin' => [
                'child_routes' => [
                    'result' => [
                        'type' => 'literal',
                        'options' => [
                            'route' => '/result',
                            'defaults' => [
                                'controller' => 'EportalResult\Controller\Result',
                                'action' => 'index'
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'assessment' => [
                                'type' => 'segment',
                                'options' => [
                                    'route' => '/assessment[/:action[/:id]]',
                                    'defaults' => [
                                        'controller' => 'EportalResult\Controller\Assessment',
                                        'action' => 'index',
                                    ],
                                    'constraints' => [
                                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                        'id' => '[0-9]+'
                                    ]
                                ]
                            ],
                            'grade' => [
                                'type' => 'segment',
                                'options' => [
                                    'route' => '/grade[/:action[/:id]]',
                                    'defaults' => [
                                        'controller' => 'EportalResult\Controller\Grade',
                                        'action' => 'index',
                                    ],
                                    'constraints' => [
                                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                        'id' => '[0-9]+'
                                    ]
                                ]
                            ],
                            
                            'upload' => [
                                'type' => 'segment',
                                'options' => [
                                    'route' => '/upload[/:action]',
                                    'defaults' => [
                                        'controller' => 'EportalResult\Controller\ResultUpload',
                                        'action' => 'index',
                                    ],
                                    'constraints' => [
                                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                    ]
                                ]
                            ],
                            
                            'view' => [
                                'type' => 'literal',
                                'options' => [
                                    'route' => '/view',
                                    'defaults' => [
                                        'controller' => 'EportalResult\Controller\ResultView',
                                        'action' => 'view'
                                    ],
                                ],
                                'may_terminate' => true,
                                'child_routes' => [
                                    'default' => [
                                        'type' => 'segment',
                                        'options' => [
                                            'route' => '/:action',
                                            'defaults' => [
                                                'controller' => 'EportalResult\Controller\ResultView',
                                                'action' => 'view'
                                            ],
                                            'constraints' => [
                                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                            ]
                                        ]
                                    ]
                                ]
                            ],
                            'create' => [
                                'type' => 'literal',
                                'options' => [
                                    'route' => '/create',
                                    'defaults' => [
                                        'controller' => 'EportalResult\Controller\ResultCreate',
                                        'action' => 'create'
                                    ]
                                ],
                                'may_terminate' => true,
                                'child_routes' => [
                                    'default' => [
                                        'type' => 'segment',
                                        'options' => [
                                            'route' => '/:action',
                                            'defaults' => [
                                                'controller' => 'EportalResult\Controller\ResultCreate',
                                                'action' => 'create'
                                            ],
                                            'constraints' => [
                                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ],
        ],
    ],
    'controllers' => [
        'invokables' => [
            'EportalResult\Controller\Result' => \EportalResult\Controller\ResultController::class,
            'EportalResult\Controller\ResultUpload' => \EportalResult\Controller\ResultUploadController::class,
            'EportalResult\Controller\ResultView' => 'EportalResult\Controller\ResultViewController',
            'EportalResult\Controller\ResultCreate' => 'EportalResult\Controller\Upload\ResultCreateController'
        ],
        'factories' => [
            'EportalResult\Controller\Assessment' => function($sm) {
                $service = $sm->getServiceLocator()->get('Result\Service\Assessment');
                return new EportalResult\Controller\AssessmentController($service);
            },
            'EportalResult\Controller\Grade' => function($sm) {
                $service = $sm->getServiceLocator()->get('Result\Service\Grade');
                return new EportalResult\Controller\GradeController($service);
            }
        ]
    ],
    'controller_plugins' => [
        'invokables' => [
            'Result' => \EportalResult\Controller\Plugin\EportalResultPlugin::class,
        ]
    ],
    'form_elements' => [
        'invokables' => [
//            'EportalResult\Fieldset\Upload' => 'EportalProperty\Form\EportalPropertyFieldset',
//            'EportalResult\Form\Upload' => 'EportalProperty\Form\EportalPropertyForm',
            'EportalResult\Form\Assessment' => \EportalResult\Form\AssessmentForm::class,
            'EportalResult\Form\Grade' => \EportalResult\Form\GradeForm::class
        ]
    ],
    'service_manager' => [
        'factories' => [
            'EportalResult\Service\Result' => function($sm) {
                $resultService = $sm->get('Result\Service\Result');
                $resultDetailService = $sm->get('Result\Service\ResultDetail');
                $resultScoreService = $sm->get('Result\Service\ResultScore');
                $assessmentService = $sm->get('Result\Service\Assessment');
                $propertyValueService = $sm->get('Property\Service\PropertyValue');
                return new EportalResult\Service\EportalResultService($resultService, $resultDetailService, $resultScoreService, $assessmentService, $propertyValueService);
            }
        ]
    ],
    'view_manager' => [
        'template_path_stack' => ['EportalResult' => __DIR__ . '/../view'],
        'strategies' => ['ViewJsonStrategy']
    ],
    'bjyauthorize' => [
        'guards' => [
            \BjyAuthorize\Guard\Route::class => [
                ['route' => 'zfcadmin/result', 'roles' => []],
                ['route' => 'zfcadmin/result/assessment', 'roles' => []],
                ['route' => 'zfcadmin/result/grade', 'roles' => []],
                
                ['route' => 'zfcadmin/result/upload', 'roles' => []],
                ['route' => 'zfcadmin/result/view', 'roles' => []],
                ['route' => 'zfcadmin/result/create', 'roles' => []]
            ]
        ]
    ]
];
