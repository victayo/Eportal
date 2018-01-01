<?php
namespace Property\Model;

/**
 *
 * @author imaleo
 *        
 */
class RelPropertyValue implements RelPropertyValueInterface
{

    private $id;
    private $parent;
    private $propertyValue;
    /**
     */
    function __construct($id = null, $propertyValue = null, $parent = null)
    {
        $this->id = $id;
        $this->parent = $parent;
        $this->propertyValue = $propertyValue;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function setPropertyValue($propertyValue)
    {
        $this->propertyValue = $propertyValue;
        return $this;
    }

    public function setParent($parent)
    {
        $this->parent = $parent;
        return $this;
    }

    public function getPropertyValue()
    {
        return $this->propertyValue;
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