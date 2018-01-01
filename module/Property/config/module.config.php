<?php

return [
    'service_manager' => [
        'factories' => [
            'Property\Mapper\Property' => \Property\Factory\Mapper\PropertyMapperFactory::class,
            'Property\Mapper\PropertyValue' => \Property\Factory\Mapper\PropertyValueMapperFactory::class,
            'Property\Service\Property' => \Property\Factory\Service\PropertyServiceFactory::class,
            'Property\Service\PropertyValue' => \Property\Factory\Service\PropertyValueServiceFactory::class,
            'Property\Hydrator\PropertyValue' => \Property\Factory\Mapper\Hydrator\PropertyValueHydratorFactory::class,
        ],
        'invokables' => [
            'Property\Hydrator\Property' => \Zend\Stdlib\Hydrator\ClassMethods::class,
        ]
    ],
    
    'form_elements' => [
        'invokables' => [
            'Property\Form\PropertyValue' => \Property\Form\PropertyValueForm::class,
            'Property\Fieldset\PropertyValue' => \Property\Form\PropertyValueFieldset::class,
        ]
    ]
];
