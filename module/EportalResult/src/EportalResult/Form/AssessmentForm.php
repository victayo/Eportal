<?php

namespace EportalResult\Form;

use Result\Model\Assessment;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * @author OKALA
 */
class AssessmentForm extends Form {

    public function __construct() {
        parent::__construct('form');
        $this->setObject(new Assessment())
                ->setHydrator(new ClassMethods());
        $this->add([
                    'name' => 'id',
                    'type' => 'hidden'
                ])
                ->add([
                    'name' => 'name',
                    'type' => 'text',
                    'attributes' => [
                        'required' => 'required'
                    ],
                    'options' => [
                        'label' => 'Assessment Name'
                    ]
                ])
                ->add([
                    'name' => 'include_in_cumulative',
                    'type' => 'Radio',
                    'options' => [
                        'label' => 'Include In Cumulative?',
                        'value_options' => [
                            '1' => 'Yes',
                            '0' => 'No'
                        ]
                    ]
                ])
                ->add([
                    'name' => 'is_exam',
                    'type' => 'Radio',
                    'options' => [
                        'label' => 'Examination?',
                        'value_options' => [
                            '1' => 'Yes',
                            '0' => 'No'
                        ]
                    ],
                    'attributes' => [
                        'required' => 'required'
                    ]
        ])
                ->add([
                    'name' => 'max_score',
                    'type' => 'Number',
                    'options' => [
                        'label' => 'Maximum Score'
                    ],
                    'attributes' => [
                        'min' => 0,
                        'max' => 100
                    ]
                ])
            ->add([
                'name' => 'submit',
                'type' => 'button',
                'attributes' => [
                    'value' => 'Submit'
                ]
            ]);
    }

}
