<?php

namespace EportalTest\Form;

use EportalUser\Form\PropertyFieldset;
use Property\Model\Property;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 *
 * @author imaleo
 */
class PropertyFieldsetTest extends \PHPUnit_Framework_TestCase {

    /**
     *
     * @var Form
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
        $this->form->setInputFilter(new InputFilter())
                ->setHydrator(new ClassMethods());
        $propertyService = $this->getMockBuilder('Property\Service\PropertyService')
                ->disableOriginalConstructor()
                ->getMock();
        $propertyService->expects($this->any())
                ->method('findByName')
                ->will($this->returnValue(new Property()));
        $propertyValueService = $this->getMockBuilder('Property\Service\PropertyValueService')
                ->disableOriginalConstructor()
                ->getMock();
        $propertyValueService->expects($this->any())
                ->method('findByProperty')
                ->will($this->returnValue(array()));
        
        $this->fieldset = new PropertyFieldset('property');
        $this->fieldset->setPropertyService($propertyService)
                ->setPropertyValueService($propertyValueService);
        $this->fieldset->init();
        $this->data = array(
            'property' => array(
                'class' => 1,
//                'section' => 1,
                'session' => 1,
                'term' => 1,
                'department' => 1,
            )
        );
        $this->fieldset->get('class')->setValueOptions(array(1 => 'one'));
//        $this->fieldset->get('section')->setValueOptions(array(1 => 'one'));
        $this->fieldset->get('session')->setValueOptions(array(1 => 'one'));
        $this->fieldset->get('term')->setValueOptions(array(1 => 'one'));
//        $this->fieldset->get('department')->setValueOptions(array(1 => 'one'));
        $this->form->add($this->fieldset);
        $this->form->setBaseFieldset($this->fieldset);
    }

    public function testFieldsetValidates() {
        $this->form->setData($this->data);
        $valid = $this->form->isValid();
        $data = $this->form->getData();
//        var_dump($this->form->getMessages());
        $this->assertTrue($valid);
        $this->assertInstanceOf('EportalUser\Model\Property', $data);
//        var_dump($this->form->getData());
    }

    public function testFormValidatesWithAFieldRemoved() {
        $element = 'section';
        $this->fieldset->remove($element);
        $this->form->setValidationGroup(array(
            'property' => array(
                'class', 'department', 'session', 'term'
            )
        ));
        $this->form->setData($this->data);
        $valid = $this->form->isValid();
        $data = $this->form->getData();
//        var_dump($valid);
//        var_dump($data);
        $this->assertTrue($valid);
    }
    
    
}
