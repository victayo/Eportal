<?php

namespace EportalUser\Form;

use EportalUser\Model\EportalUser;
use Zend\Form\Element\DateSelect;
use Zend\Form\Element\Select;
use Zend\Form\Fieldset;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 *
 * @author imaleo
 */
class EportalUserFieldset extends Fieldset{

    public function __construct($name = null) {
        if (!$name) {
            $name = 'user';
        }
        parent::__construct($name);
        $this->setObject(new EportalUser())
                ->setHydrator(new ClassMethods());
        $this->add([
            'name' => 'id',
            'type' => 'Hidden'
        ]);
        $this->add(array(
                    'name' => 'first_name',
                    'attributes' => array(
                        'type' => 'text',
                        'required' => 'required'
                    ),
                    'options' => array(
                        'label' => 'First Name'
                    )
                ))
                ->add(array(
                    'name' => 'last_name',
                    'attributes' => array(
                        'type' => 'text',
                        'required' => 'required'
                    ),
                    'options' => array(
                        'label' => 'Last Name'
                    )
                ))
                ->add(array(
                    'name' => 'middle_name',
                    'attributes' => array(
                        'type' => 'text',
                        'required' => 'required'
                    ),
                    'options' => array(
                        'label' => 'Other Name(s)'
                    )
                ))
                ->add(array(
                    'name' => 'username',
                    'attributes' => array(
                        'type' => 'text',
                        'required' => 'required'
                    ),
                    'options' => array(
                        'label' => 'Registration Number'
                    )
        ));
        $gender = new Select('gender');
        $gender->setDisableInArrayValidator(true)
                ->setAttribute('required', 'required')
                ->setValueOptions(array(
                    1 => 'Male',
                    2 => 'Female'
                ))
                ->setEmptyOption('Select Gender')
                ->setLabel('Gender');
        $dob = new DateSelect('dob'); //output format: Y-m-d
        $dob->setShouldCreateEmptyOption(true)
//                ->setShouldRenderDelimiters(FALSE)
                ->setMaxYear(date('Y') - 30)
                ->setMinYear(date('Y') - 18)
                ->setLabel('Date Of Birth')
                ->setAttribute('required', 'required');
        $this->add($gender)
                ->add($dob);
    }
}
