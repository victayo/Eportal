<?php

return [
    'router' => [
        'routes' => [
            'zfcadmin' => [
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => [
                    'route' => '/admin',
                    'defaults' => [
                        'controller' => 'EportalAdmin\Controller\EportalAdmin',
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [],
            ],
        ],
    ],
];

