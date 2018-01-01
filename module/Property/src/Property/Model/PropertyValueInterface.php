<?php
namespace Property\Model;

/**
 *
 * @author imaleo
 *        
 */
interface PropertyValueInterface
{
    /**
     * @return int
     */
    public function getId();
    
    /**
     * 
     * @param int $id
     * @return PropertyValueInterface
     */
    public function setId($id);
    
    /**
     * @return PropertyInterface
     */
    public function getValue();
    
    /**
     * 
     * @param string $value
     * @return PropertyValueInterface
     */
    public function setValue($value);
    
    /**
     * 
     * @return PropertyInterface
     */
    public function getProperty();
    
    /**
     * 
     * @param PropertyInterface $property
     * @return PropertyValueInterface
     */
    public function setProperty($property);
}

