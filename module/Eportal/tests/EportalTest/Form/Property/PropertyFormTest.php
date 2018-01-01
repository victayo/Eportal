<?php

namespace EportalTest\Form\Property;

use Eportal\Form\Property\PropertyForm;

/**
 * Description of PropertyForm
 *
 * @author imaleo
 */
class PropertyFormTest extends \PHPUnit_Framework_TestCase {

    protected $form;
    protected $baseFieldset;
    protected $data;
    
    public function setUp() {
        parent::setUp();
        $this->baseFieldset = $this->getMockBuilder('Eportal\Form\Property\PropertyBaseFieldset')
                ->setConstructorArgs(array('test'))
                ->setMethods(null)
                ->getMock();
        $this->form = new PropertyForm('test-form', $this->baseFieldset);
        $this->form->remove('csrf');
        $this->data = array(
            $this->baseFieldset->getName() => array(
                'id' => 1,
                'value' => 'value'
            ),
        );
    }

    public function testPropertyFormIsProperlyConstructed() {
        $this->assertSame($this->baseFieldset, $this->form->getBaseFieldset());
        $this->assertEquals($this->baseFieldset->getName(), 'test');
    }

    public function testFormValidatesWithCorrectData() {
        $this->form->setData($this->data);
        $this->assertTrue($this->form->isValid());
    }

    public function testFormInvalidatesWithInCorrectData() {
        unset($this->data[$this->baseFieldset->getName()]['value']);
        $this->form->setData($this->data);
        $this->assertFalse($this->form->isValid());
    }
}
