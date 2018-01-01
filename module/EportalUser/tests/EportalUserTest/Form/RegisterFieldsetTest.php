<?php

namespace EportalTest\Form;

/**
 *
 * @author imaleo
 */
class RegisterFieldsetTest extends \PHPUnit_Framework_TestCase {

    /**
     *
     * @var \Zend\Form\Form
     */
    protected $form;
    protected $fieldset;
    protected $data;

    public function setUp() {
        parent::setUp();
        $this->form = $this->getMockBuilder('Zend\Form\Form')
                ->setConstructorArgs(array('form', array()))
                ->setMethods(null)
                ->getMock();
        $this->form->setInputFilter(new \Zend\InputFilter\InputFilter())
                ->setHydrator(new \Zend\Stdlib\Hydrator\ClassMethods());
        $this->fieldset = new \EportalUser\Form\EportalRegistrationFieldset('register');
        $this->fieldset->init();
        $this->data = array(
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
            )
        );
        $this->fieldset->get('property')->get('class')->setValueOptions(array(1 => 'one'));
        $this->fieldset->get('property')->get('section')->setValueOptions(array(1 => 'one'));
        $this->fieldset->get('property')->get('session')->setValueOptions(array(1 => 'one'));
        $this->fieldset->get('property')->get('term')->setValueOptions(array(1 => 'one'));
        $this->fieldset->get('property')->get('department')->setValueOptions(array(1 => 'one'));
        $this->form->add($this->fieldset);
        $this->form->setBaseFieldset($this->fieldset);
    }

   public function testFieldsetValidates(){
        $this->form->setData($this->data);
        $valid = $this->form->isValid();
        $this->assertTrue($valid);
        $data = $this->form->getData();
        $this->assertInstanceOf('EportalUser\Model\Register', $data);
//        var_dump($this->form->getData());
    }
}
