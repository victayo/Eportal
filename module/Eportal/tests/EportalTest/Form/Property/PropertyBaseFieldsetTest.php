<?php


namespace EportalTest\Form\Property;

use Eportal\Form\Property\PropertyBaseFieldset;
use Eportal\Form\Property\PropertyForm;

class PropertyBaseFieldsetTest extends \PHPUnit_Framework_TestCase {
    protected $fieldset;
    /**
     *
     * @var PropertyForm
     */
    protected $form;
    protected $data;
    
    public function setUp() {
        parent::setUp();
        $this->fieldset = new PropertyBaseFieldset('test');
        $this->form = $this->getMockBuilder('Eportal\Form\Property\PropertyForm')
                ->setConstructorArgs(array('form',$this->fieldset))
                ->setMethods(null)
                ->getMock();
        $this->data = array(
            $this->fieldset->getName() => array(
                'id' => 1,
                'value' => 'value',
            )
        );
        $this->form->remove('csrf');
    }
    
    public function testFormValidatesWithCorrectData(){
        $this->form->setData($this->data);
        $this->assertTrue($this->form->isValid());
    }
    
    public function testFormInvalidatesWithInCorrectData() {
        unset($this->data[$this->fieldset->getName()]['value']);
        $this->form->setData($this->data);
        $this->assertFalse($this->form->isValid());
    }
    
    public function testFormBindsWithEmptyPropertyObject() {
        $property = new \Eportal\Model\Property();
        $this->form->bind($property);
        $this->form->setData($this->data);
        $this->assertTrue($this->form->isValid());
        $formData = $this->form->getData();
        $this->assertInstanceOf('Eportal\Model\Property', $formData);
        $this->assertSame($property->getValue(), $formData->getValue());
    }
    
    public function testFormBindsWhenSectionObjectIsNotEmpty() {
        $property = new \Eportal\Model\Property();
        $property->setId(2)
                ->setValue('section_c');
        $this->form->bind($property);
        $this->form->setData($this->data);
        $this->assertTrue($this->form->isValid());
        $formData = $this->form->getData();
        $this->assertInstanceOf('Eportal\Model\Property', $formData);
        $this->assertSame($property->getValue(), $this->data[$this->fieldset->getName()]['value']);
    }
}
