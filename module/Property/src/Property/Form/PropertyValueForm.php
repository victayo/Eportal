<?php

namespace Property\Form;

use ZfcBase\Form\ProvidesEventsForm;

/**
 *
 * @author imaleo
 */
class PropertyValueForm extends ProvidesEventsForm{
    public function __construct($name = null) {
      if(!$name){
            $name = 'form';
        }
        parent::__construct($name);
        $this->setAttribute('method', 'POST');
        
        $this->add(array(
                    'name' => 'submit',
                    'attributes' => array(
                        'type' => 'submit',
                        'value' => 'Submit'
                    )
                ))
                ->add(array(
                    'name' => 'csrf',
                    'type' => 'Zend\Form\Element\Csrf'
        )); 
    }
    
    public function init() {
        parent::init();
        $this->add(array(
            'name' => 'property',
            'type' => 'Property\Fieldset\PropertyValue',
            'options' => array(
                'use_as_base_fieldset' => true
            )
        ));
    }
}
