<?php

namespace Result\Mapper;

use Zend\Stdlib\Hydrator\HydratorInterface;
use ZfcBase\Mapper\AbstractDbMapper;

/**
 *
 * @author imaleo
 *        
 */
abstract class AbstractResultDbMapper extends AbstractDbMapper {
    /*
     * @see \ZfcBase\Mapper\AbstractDbMapper::delete()
     */

    public function delete($where, $tableName = null) {
        return parent::delete($where, $tableName);
    }

    /*
     * @see \ZfcBase\Mapper\AbstractDbMapper::insert()
     */

    public function insert($entity, $tableName = null, HydratorInterface $hydrator = null) {
        $result = parent::insert($entity, $tableName, $hydrator);
        $genVal = $result->getGeneratedValue();
        if ($genVal && method_exists($entity, 'setId')) {
            $entity->setId($result->getGeneratedValue());
        }
        return $result;
    }

    /*
     * @see \ZfcBase\Mapper\AbstractDbMapper::update()
     */

    public function update($entity, $where, $tableName = null, HydratorInterface $hydrator = null) {
        if (!$where &&  method_exists($entity, 'getId')) {
           $where = array('id = ?' => $entity->getId());
        }
        return parent::update($entity, $where, $tableName, $hydrator);
    }

    public function getAll(){
        return $this->select($this->getSelect());
    }
    
    public function getTableName() {
        return $this->tableName;
    }

    public function setTableName($tableName) {
        $this->tableName = $tableName;
        return $this;
    }

}
