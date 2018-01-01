<?php

namespace EportalTest\Form;

/**
 *
 * @author imaleo
 */
class UserFieldsetTest extends \PHPUnit_Framework_TestCase {

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
        $this->fieldset = new \EportalUser\Form\EportalUserFieldset('user');
        $this->data = array(
            'user' => array(
                'first_name' => 'First Name',
                'middle_name' => 'Middle Name',
                'last_name' => 'Last Name',
                'username' => 'Username',
                'dob' => '2012-01-05',
                'gender' => 2
            ),
        );
        $this->form->add($this->fieldset);
        $this->form->setBaseFieldset($this->fieldset);
    }

    public function testFieldsetValidates() {
        $this->form->setData($this->data);
        $this->assertTrue($this->form->isValid());
        $data = $this->form->getData();
        $this->assertInstanceOf('EportalUser\Model\EportalUser', $data);
//        var_dump($this->form->getData());
    }

}
