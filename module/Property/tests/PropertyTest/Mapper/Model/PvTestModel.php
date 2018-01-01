<?php


namespace PropertyTest\Mapper\Model;

use Property\Model\PropertyValue;

/**
 * Description of PvTestModel
 *
 * @author imaleo
 */
class PvTestModel extends PropertyValue {
    private $id;
    private $value;
    private $property;
    
    function __construct($id = NULL, $value = NULL, $property = NULL)
    {
        $this->id = $id;
        $this->value = $value;
        $this->property = $property;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getProperty()
    {
        return $this->property;
    }
    
    public function setProperty($property)
    {
        $this->property = $property;
        return $this;
    }

    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }
    
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    
    public function getId()
    {
        return $this->id;
    }
}
