<?php

namespace EportalProperty\Form;

use EportalProperty\Model\EportalProperty;
use Zend\Form\Element\Select;
use Zend\Form\Fieldset;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 *
 * @author imaleo
 */
class EportalPropertyFieldset extends Fieldset {

    public function __construct($name = null) {
        if (!$name) {
            $name = 'eportal_property';
        }
        parent::__construct($name);
        $this->setObject(new EportalProperty())
                ->setHydrator(new ClassMethods());
    }

    public function init() {
        parent::init();
        $session = new Select('session');
        $session->setDisableInArrayValidator(true)
                ->setAttributes([
                    'required' => 'required',
                    'id' => 'property_session'
                ])
                ->setLabel('Session')
                ->setOptions([
                    'label_attributes' => [
                        'class' => 'control-label col-sm-2'
                    ]
        ]);
        $term = new Select('term');
        $term->setEmptyOption('Select Term')
                ->setAttributes(['required' => 'required',
                    'id' => 'property_term'
                ])
                ->setDisableInArrayValidator(true)
                ->setLabel('Term')
                ->setOptions([
                    'label_attributes' => [
                        'class' => 'control-label col-sm-2'
                    ]
        ]);
        $school = new Select('school');
        $school->setDisableInArrayValidator(true)
                ->setEmptyOption('Select School')->setAttributes(['required' => 'required',
                    'id' => 'property_school'
                ])
                ->setLabel('School')
                ->setOptions([
                    'label_attributes' => [
                        'class' => 'control-label col-sm-2'
                    ]
        ]);
        $class = new Select('class');
        $class->setEmptyOption('Select Class')
                ->setDisableInArrayValidator(true)
                ->setAttributes([
                    'required' => 'required',
                    'id' => 'property_class'
                ])
                ->setLabel('Class')
                ->setOptions([
                    'label_attributes' => ['class' => 'control-label col-sm-2']
                ]);
        $department = new Select('department');
        $department->setEmptyOption('Select Department')
                ->setDisableInArrayValidator(true)
                ->setAttributes(['required' => 'required',
                    'id' => 'property_department'
                ])
                ->setLabel('Department')
                ->setOptions([
                    'label_attributes' => [
                        'class' => 'control-label col-sm-2'
                    ]
        ]);

        $subject = new Select('subject');
        $subject->setEmptyOption('Select Subject')
                ->setDisableInArrayValidator(TRUE)
                ->setAttributes(['required' => 'required',
                    'id' => 'property_subject'
                ])
                ->setLabel('Subject')
                ->setOptions([
                    'label_attributes' => [
                        'class' => 'control-label col-sm-2'
                    ]
                ]);
        $this->add($session)
                ->add($term)
                ->add($school)
                ->add($class)
                ->add($department)
                ->add($subject);
    }

}
