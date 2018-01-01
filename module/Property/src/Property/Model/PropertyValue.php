<?php
namespace Property\Model;

/**
 *
 * @author imaleo
 *        
 */
class PropertyValue implements PropertyValueInterface
{

    private $id;
    private $value;
    private $property;
    /**
     * 
     * @param string $id
     * @param string $value
     * @param PropertyInterface $property
     */
    function __construct($id = NULL, $value = NULL, PropertyInterface $property = NULL)
    {
        $this->id = $id;
        $this->value = $value;
        $this->property = $property;
    }

    /**
     *
     * @see \Property\Model\PropertyValueInterface::getValue()
     *
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     *
     * @see \Property\Model\PropertyValueInterface::getProperty()
     *
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     *
     * @see \Property\Model\PropertyValueInterface::setProperty()
     *
     */
    public function setProperty($property)
    {
        $this->property = $property;
        return $this;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Property\Model\PropertyValueInterface::setValue()
     *
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     *
     * @see \Property\Model\PropertyValueInterface::setId()
     *
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     *
     * @see \Property\Model\PropertyValueInterface::getId()
     *
     */
    public function getId()
    {
        return $this->id;
    }
}

?>