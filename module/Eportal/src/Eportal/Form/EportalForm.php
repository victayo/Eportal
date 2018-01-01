<?php

namespace Eportal\Form;

use Zend\InputFilter\InputFilter;
use Zend\Stdlib\Hydrator\ClassMethods;
use ZfcBase\Form\ProvidesEventsForm;

/**
 *
 * @author imaleo
 */
class EportalForm extends ProvidesEventsForm {

    public function __construct($name = null) {
        if (null === $name) {
            $name = 'form';
        }
        parent::__construct($name);
        $this->setInputFilter(new InputFilter())
                ->setHydrator(new ClassMethods())
                ->setAttribute('method', 'POST');

        $this->add([
                    'name' => 'submit',
                    'attributes' => [
                        'type' => 'submit',
                        'value' => 'Submit'
                    ]
                ]);
    }

}
