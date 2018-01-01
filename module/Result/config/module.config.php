<?php

return [
    'service_manager' => [
        'invokables' => [
            'Result\Service\ResultDetail' => \Result\Service\ResultDetailService::class,
        ],
        'factories' => [
            'Result\Service\Result' => \Result\Factory\Service\ResultServiceFactory::class,
            'Result\Service\ResultScore' => \Result\Factory\Service\ResultScoreServiceFactory::class,
            'Result\Service\Grade' => \Result\Factory\Service\GradeServiceFactory::class,
            'Result\Service\Assessment' => \Result\Factory\Service\AssessmentServiceFactory::class,
            'Result\Service\Remark' => \Result\Factory\Service\RemarkServiceFactory::class,
            //mappers
            'Result\Mapper\Result' => \Result\Factory\Mapper\ResultMapperFactory::class,
            'Result\Mapper\ResultScore' => \Result\Factory\Mapper\ResultScoreMapperFactory::class,
            'Result\Mapper\Grade' => \Result\Factory\Mapper\GradeMapperFactory::class,
            'Result\Mapper\Assessment' => \Result\Factory\Mapper\AssessmentMapperFactory::class,
            'Result\Mapper\Remark' => \Result\Factory\Mapper\RemarkMapperFactory::class,
        ]
    ],
];
