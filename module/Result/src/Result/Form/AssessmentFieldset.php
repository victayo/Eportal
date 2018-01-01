<?php

namespace Result\Form;

use Result\Model\Assessment;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 *
 * @author imaleo
 */
class AssessmentFieldset extends Fieldset implements InputFilterProviderInterface {

    public function __construct($name = null) {
        if (!$name) {
            $name = 'assessment';
        }
        parent::__construct($name);
        $this->setObject(new Assessment())
                ->setHydrator(new ClassMethods());
        $this->add(array(
                    'name' => 'id',
                    'type' => 'hidden'
                ))
                ->add(array(
                    'name' => 'name',
                    'type' => 'text',
                    'options' => array(
                        'label' => 'Assessment Name'
                    ),
                    'attributes' => array(
                        'required' => 'required'
                    )
                ))
//            ->add(array(
//                'name' => 'max_score',
//                'type' => 'text',
//                'attributes' => array(
//                    'value' => 100,
//                ),
//                'options' => array(
//                    'label' => 'Max Score'
//                )
//            ))
                ->add(array(
                    'name' => 'max_score',
                    'type' => 'Number',
                    'options' => array(
                        'label' => 'Max Score'
                    ),
                    'attributes' => array(
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                        'value' => 100
                    )
                ))
                ->add(array(
                    'name' => 'is_exam',
                    'type' => 'radio',
                    'options' => array(
                        'label' => 'Assessement is Examination?',
                        'value_options' => array(
                            '1' => 'Yes',
                            '0' => 'No'
                        )
                    ),
                    'attributes' => array(
                        'value' => '0'
                    )
                ))
                ->add(array(
                    'name' => 'include_in_cumulative',
                    'type' => 'radio',
                    'options' => array(
                        'label' => 'Should assessment be included in cumulative?',
                        'value_options' => array(
                            '1' => 'Yes',
                            '0' => 'No'
                        )
                    ),
                    'attributes' => array(
                        'value' => '1'
                    )
        ));
    }

    public function getInputFilterSpecification() {
        return array(
            'name' => array(
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'StringTrim'
                    )
                ),
                'validators' => array(
                    array(
                        'name' => 'NotEmpty'
                    )
                )
            ),
            'max_score' => array(
                'required' => true,
            )
        );
    }

}
