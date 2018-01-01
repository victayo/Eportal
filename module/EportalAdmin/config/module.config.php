<?php

return array(
    'form_elements' => array(
        'invokables' => array(
            'EportalAdmin\Fieldset\ResultPass' => 'EportalAdmin\Form\Result\ResultPassFieldset',
            'EportalAdmin\Form\ResultPass' => 'EportalAdmin\Form\Result\ResultPassForm'
        )
    ),
    'controllers' => array(
        'invokables' => array(
            'EportalAdmin\Controller\EportalAdmin' => 'EportalAdmin\Controller\EportalAdminController',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
//            'EportalAdmin\Mapper\Setting' => \EportalAdmin\Factory\Mapper\SettingMapperFactory::class,
//            'EportalAdmin\Service\Setting' => \EportalAdmin\Factory\Service\SettingServiceFactory::class
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'EportalAdmin' => __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        )
    ),
    'bjyauthorize' => [
        'guards' => [
            \BjyAuthorize\Guard\Route::class => [
                ['route' => 'zfcadmin', 'roles' => []],
            ]
        ]
    ]
);
