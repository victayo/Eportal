<?php

namespace EportalUser\Form;

use ZfcUser\Form\RegisterFilter;
use ZfcUser\Options\RegistrationOptionsInterface;

/**
 * @author OKALA
 */
class EportalUserRegisterFilter extends RegisterFilter{
    
    public function __construct($emailValidator, $usernameValidator, RegistrationOptionsInterface $options) {
        parent::__construct($emailValidator, $usernameValidator, $options);
        $this->remove('email')
                ->remove('password')
                ->remove('passwordVerify');
        $this->add(array(
                'name'       => 'first_name',
                'required'   => true,
                'filters'    => array(array('name' => 'StringTrim')),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'min' => 3,
                            'max' => 128,
                        ),
                    ),
                ),
            ))->add(array(
                'name'       => 'last_name',
                'required'   => true,
                'filters'    => array(array('name' => 'StringTrim')),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'min' => 3,
                            'max' => 128,
                        ),
                    ),
                ),
            ))
                ->add(array(
                'name'       => 'middle_name',
                'required'   => true,
                'filters'    => array(array('name' => 'StringTrim')),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'min' => 3,
                            'max' => 128,
                        ),
                    ),
                ),
            ));
    }
}
