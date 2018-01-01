<?php

namespace EportalResult\Form;

use Result\Model\Grade;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * @author OKALA
 */
class GradeForm extends Form {

    public function __construct() {
        parent::__construct('form');
        $this->setObject(new Grade())
                ->setHydrator(new ClassMethods());
        $this->add([
                    'name' => 'id',
                    'type' => 'Hidden'
                ])
                ->add([
                    'name' => 'grade',
                    'type' => 'text',
                    'options' => [
                        'label' => 'Grade'
                    ],
                    'attributes' => [
                        'required' => 'required'
                    ]
                ])
                ->add([
                    'name' => 'min',
                    'type' => 'Number',
                    'options' => [
                        'label' => 'Minimum Score'
                    ],
                    'attributes' => [
                        'required' => 'required'
                    ]
                ])
                ->add([
                    'name' => 'max',
                    'type' => 'Number',
                    'options' => [
                        'label' => 'Maximum Score'
                    ],
                    'attributes' => [
                        'required' => 'required'
                    ]
                ])
                ->add([
                    'name' => 'remark',
                    'type' => 'Text',
                    'options' => [
                        'label' => 'Remark'
                    ]
                ])
                ->add([
                    'name' => 'submit',
                    'type' => 'Button',
                    'attributes' => [
                        'value' => 'submit'
                    ]
        ]);
    }

}
