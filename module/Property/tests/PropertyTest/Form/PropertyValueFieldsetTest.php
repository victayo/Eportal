<?php

namespace PropertyTest\Form;

use Property\Form\PropertyValueFieldset;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Stdlib\Hydrator\ClassMethods;
/**
 * Description of PropertyValueFieldsetTest
 *
 * @author imaleo
 */
class PropertyValueFieldsetTest extends \PHPUnit_Framework_TestCase {
    protected $fieldset;
    /**
     *
     * @var Form
     */
    protected $form;
    protected $data;
    
    public function setUp() {
        parent::setUp();
        $this->fieldset = new PropertyValueFieldset('property_value');
        $this->form = new Form();
        $this->form->setHydrator(new ClassMethods(false))
                ->setInputFilter(new InputFilter);
        $this->form->add($this->fieldset)
                ->setBaseFieldset($this->fieldset);
        $this->data = array(
            $this->fieldset->getName() => array(
                'id' => 1,
                'value' => 'value'
            )
        );
    }
    
    public function testFormValidatesWithCorrectData() {
        $this->form->setData($this->data);
        $this->assertTrue($this->form->isValid());
//        \Zend\Debug\Debug::dump($this->form->getData());
    }
    
    public function testFormValidatesOnBind() {
        $pv = new \Property\Model\PropertyValue(2, 'value_2', new \Property\Model\Property(1, 'property'));
        $this->form->bind($pv);
        $this->assertTrue($this->form->isValid());
        $data = $this->form->getData();
        $this->assertInstanceOf('Property\Model\PropertyValueInterface', $data);
        $this->assertEquals($data->getId(), $pv->getId());
        $this->assertEquals($data->getProperty(), $pv->getProperty());
//        \Zend\Debug\Debug::dump($this->form->getData());
    }
}
