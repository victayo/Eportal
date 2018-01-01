<?php
namespace Property\Service;

use Property\Model\PropertyInterface;
/**
 *
 * @author imaleo
 *        
 */
interface PropertyServiceInterface
{
    /**
     * @return \Zend\Db\ResultSet\HydratingResultSet;
     */
    public function findAll($array = false);
    
    /**
     * 
     * @param int $id
     * @return PropertyInterface
     */
    public function findById($id, $array = false);
    
    /**
     * 
     * @param string $name
     * @return PropertyInterface
     */
    public function findByName($name, $array = false);
    
    /**
     * 
     * @param PropertyInterface $property
     * @return PropertyInterface
     */
    public function insert(PropertyInterface $property);
    
    /**
     *
     * @param PropertyInterface $property
     * @return PropertyInterface
     */
    public function update(PropertyInterface $property);
    
    /**
     *
     * @param PropertyInterface $property
     * @return PropertyInterface
     */
    public function delete(PropertyInterface $property);
}

