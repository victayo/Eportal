<?php
namespace EportalUser\Form;

use EportalUser\Model\Register;
use Zend\Form\Fieldset;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 *
 * @author imaleo
 */
class EportalRegistrationFieldset extends Fieldset{
    
    public function __construct($name = null){
        if(!$name){
            $name = 'register';
        }
        parent::__construct($name);
        $this->setHydrator(new ClassMethods())
                ->setObject(new Register());
        $this->add([
            'name' => 'user',
            'type' => 'EportalUser\Form\EportalUserFieldset'
        ]);
    }
    
    public function init() {
        parent::init();
        $this->add(array(
            'name' => 'property',
            'type' => 'EportalProperty\Fieldset\EportalProperty'
        ));
    }
}
