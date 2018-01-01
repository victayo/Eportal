<?php

namespace EportalUser\Form;

use Zend\Stdlib\Hydrator\ClassMethods;
use ZfcBase\Form\ProvidesEventsForm;

/**
 * @author OKALA
 */
class EportalRegistrationForm extends ProvidesEventsForm{
   
    public function __construct($name = null) {
        parent::__construct($name);
        $this->setHydrator(new ClassMethods());
        $this->setValidationGroup([
            'register' => [
                'property' => [
                    'school', 'class', 'session', 'term'
                ],
                'user' => [
                    'first_name', 'middle_name', 'last_name', 'username', 'gender', 'dob'
                ]
            ]
        ]);
        $this->add([
                    'name' => 'submit',
                    'attributes' => [
                        'type' => 'submit',
                        'value' => 'Submit'
                    ]
                ]);
    }

    public function init() {
        $this->add([
            'name' => 'register',
            'type' => 'EportalUser\Fieldset\Register',
            'options' => [
                'use_as_base_fieldset' => true
            ]
        ]);
    }
}
