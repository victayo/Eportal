<?php
namespace Property\Mapper;

/**
 *
 * @author imaleo
 *        
 */
interface PropertyMapperInterface
{
    public function save($entity);
    
    public function delete();
    
    /**
     * @return \Zend\Db\ResultSet\HydratingResultSet
     */
    public function findAll();
    
    /**
     * 
     * @param int $id
     * @return \Property\Model\PropertyInterface 
     */
    public function findById($id);
    
    /**
     * 
     * @param int $name
     * @return \Property\Model\PropertyInterface 
     */
    public function findByName($name);
}
