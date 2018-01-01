<?php

namespace EportalProperty\Form;

use ZfcBase\Form\ProvidesEventsForm;

/**
 *
 * @author imaleo
 */
class EportalPropertyForm extends ProvidesEventsForm{
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
                ));
    }
    
    public function init() {
        parent::init();
        $this->add(array(
            'name' => 'eportal_property',
            'type' => 'EportalProperty\Fieldset\EportalProperty',
            'options' => array(
                'use_as_base_fieldset' => true
            )
        ));
    }
}
