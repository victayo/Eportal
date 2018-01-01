<?php

namespace EportalUser\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 *
 * @author imaleo
 */
class UserUploadForm extends Form{
    
    public function __construct($name = null) {
      if(!$name){
            $name = 'form';
        }
        parent::__construct($name);
        $this->setAttribute('method', 'POST')
                ->setAttribute('enctype', 'multipart/form-data');
        
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
            'name' => 'upload',
            'type' => 'EportalUser\Fieldset\UserUpload',
            'options' => array(
                'use_as_base_fieldset' => true
            )
        ));
    }
}
