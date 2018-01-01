<?php

namespace Property\Form;

use Property\Model\PropertyValue;
use Zend\Form\Fieldset;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 *
 * @author imaleo
 */
class PropertyValueFieldset extends Fieldset {


    public function __construct($name = null) {
        if (!$name) {
            $name = 'property';
        }
        parent::__construct($name);
        $this->setHydrator(new ClassMethods());
        $this->setObject(new PropertyValue());
    }

    public function init(){
        $this->add(array(
            'name' => 'id',
            'type' => 'hidden'
        ));
        $this->add(array(
            'name' => 'value',
            'attributes' => array(
                'type' => 'text',
                'required' => 'required'
            ),
        ));
    }
    
    public function getInputFilterSpecification() {
        return [];
    }

}

