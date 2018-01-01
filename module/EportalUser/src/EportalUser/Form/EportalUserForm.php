<?php

namespace EportalUser\Form;

use Zend\Stdlib\Hydrator\ClassMethods;
use ZfcBase\Form\ProvidesEventsForm;

/**
 * @author OKALA
 */
class EportalUserForm extends ProvidesEventsForm {

    public function __construct($name = null) {
        parent::__construct($name);
        $this->setHydrator(new ClassMethods());
        $this->add(array(
            'name' => 'user',
            'type' => 'EportalUser\Form\EportalUserFieldset',
            'options' => [
                'use_as_base_fieldset' => true
    ]));
        $this->add([
            'name' => 'submit',
            'attributes' => [
                'type' => 'submit',
                'value' => 'Submit'
            ]
        ]);
    }
}
