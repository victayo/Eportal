<?php

namespace EportalTest\Form;

use EportalUser\Form\UserRegistrationForm;

/**
 *
 * @author imaleo
 */
class UserRegistrationFormTest extends \PHPUnit_Framework_TestCase {

    protected $form;
    protected $postData;

    public function setUp() {
        parent::setUp();
        $this->form = new UserRegistrationForm('form');
        $this->form->remove('csrf');
        $this->postData = array(
            'register' => array(
                'user' => array(
                    'first_name' => 'First Name',
                    'middle_name' => 'Middle Name',
                    'last_name' => 'Last Name',
                    'username' => 'Username',
                    'dob' => '2012-10-5',
                    'gender' => 2
                ),
                'property' => array(
                    'class' => 1,
                    'section' => 1,
                    'department' => 1,
                    'session' => 1,
                    'term' => 1
                )
        ));
        $fieldset = $this->form->getBaseFieldset();
        $fieldset->get('property')->get('class')->setValueOptions(array(1 => 'one'));
        $fieldset->get('property')->get('section')->setValueOptions(array(1 => 'one'));
        $fieldset->get('property')->get('session')->setValueOptions(array(1 => 'one'));
        $fieldset->get('property')->get('term')->setValueOptions(array(1 => 'one'));
        $fieldset->get('property')->get('department')->setValueOptions(array(1 => 'one'));
    }

    public function testForm() {
        $this->form->setData($this->postData);
        $valid = $this->form->isValid();
        $data = $this->form->getData();
        $this->assertTrue($valid);
        $this->assertInstanceOf('EportalUser\Model\Register', $data);
    }

}
