<?php

namespace EportalAdminTest\Form\Property;

use EportalAdmin\Form\Property\PropertyForm;
use EportalAdmin\Form\Property\SectionFieldset;
use EportalAdmin\Model\Section;

/**
 * Description of SectionFieldsetTest
 *
 * @author imaleo
 */
class SectionFieldsetTest extends \PHPUnit_Framework_TestCase{
    
    protected $fieldset;
    /**
     *
     * @var PropertyForm
     */
    protected $form;
    protected $data;
    
    public function setUp(){
        parent::setUp();
        $this->fieldset = new SectionFieldset();
        $this->form = $this->getMockBuilder('EportalAdmin\Form\Property\PropertyForm')
                ->setConstructorArgs(array('section_form',$this->fieldset))
                ->setMethods(null)
                ->getMock();
        $this->data = array(
            $this->fieldset->getName() => array(
                'id' => 1,
                'value' => 'section_a',
                'classes' => array(1,2,3)
            )
        );
        $this->form->remove('csrf');
    }
    
    public function testFormValidatesWithCorrectData() {
        $this->form->setData($this->data);
        $this->assertTrue($this->form->isValid());
    }
    
    public function testFormInvalidatesWithInCorrectData() {
        unset($this->data[$this->fieldset->getName()]['classes']);
        $this->form->setData($this->data);
        $this->assertFalse($this->form->isValid());
    }
    
    public function testFormBindsWithEmptySectionObject() {
        $section = new Section();
        $this->form->bind($section);
        $this->form->setData($this->data);
        $this->assertTrue($this->form->isValid());
        $formData = $this->form->getData();
        $this->assertInstanceOf('EportalAdmin\Model\Section', $formData);
        $this->assertSame($section->getClasses(), $formData->getClasses());
        $this->assertSame($section->getValue(), $formData->getValue());
    }
    
    public function testFormBindsWhenSectionObjectIsNotEmpty() {
        $section = new Section();
        $section->setId(2)
                ->setClasses(array('class_a','class_b','class_c'))
                ->setValue('section_c');
        $this->form->bind($section);
        $this->form->setData($this->data);
//        $this->form->get('section')->get('classes')->setOption('value_options', $section->getClasses());
        $this->assertTrue($this->form->isValid());
        $formData = $this->form->getData();
        $this->assertInstanceOf('EportalAdmin\Model\Section', $formData);
        $this->assertSame($section->getClasses(), $this->data[$this->fieldset->getName()]['classes']);
        $this->assertSame($section->getValue(), $this->data[$this->fieldset->getName()]['value']);
    }
}
