<?php

namespace EportalSetting\Form;

use EportalProperty\Form\EportalPropertyFieldset;
use EportalSetting\Form\Model\EportalSetting;
use Zend\Form\Fieldset;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 *
 * @author imaleo
 */
class EportalSettingFieldset extends Fieldset{
    public function __construct($name = null) {
        if(null === $name){
            $name = 'setting';
        }
        parent::__construct($name);
        $this->setObject(new EportalSetting())
                ->setHydrator(new ClassMethods());
        $this->add([
            'name' => 'property',
            'type' => EportalPropertyFieldset::class,
        ]);
    }
}
