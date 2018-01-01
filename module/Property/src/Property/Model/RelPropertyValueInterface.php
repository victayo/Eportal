<?php
namespace Property\Model;

/**
 *
 * @author imaleo
 *        
 */
interface RelPropertyValueInterface
{
    public function getId();
    public function setId($id);
    public function getParent();
    public function setParent($parent);
    public function getPropertyValue();
    public function setPropertyValue($propertyValue);
}

