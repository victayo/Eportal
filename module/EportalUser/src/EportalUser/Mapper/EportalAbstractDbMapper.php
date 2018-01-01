<?php

namespace EportalUser\Mapper;

use EportalUser\Model\EportalUserInterface;
use Property\Model\PropertyValueInterface;
use Zend\Stdlib\Hydrator\HydratorInterface;
use ZfcBase\Mapper\AbstractDbMapper;

/**
 *
 * @author imaleo
 *        
 */
abstract class EportalAbstractDbMapper extends AbstractDbMapper {

    protected $userTable = 'eportal_user';
    protected $ustTable = 'user_session_term';
    protected $upvTable = 'user_property_value';
    protected $propertyValueTable = 'property_value';
    protected $userHydrator;
    protected $userEntity;
    protected $propertyValueEntity;
    protected $propertyValueHydrator;

   
    public function insert($entity, $tableName = null, HydratorInterface $hydrator = null) {
        $result = parent::insert($entity, $tableName, $hydrator);
        if (method_exists($entity, 'setId')) {
            $entity->setId($result->getGeneratedValue());
        }
        return $entity;
    }

    public function update($entity, $where = null, $tableName = null, HydratorInterface $hydrator = null) {
        if (!$where) {
            $where = array('id = ?' => $entity->getId());
        }
        return parent::update($entity, $where, $tableName, $hydrator);
    }

    public function delete($where, $tableName = null) {
        return parent::delete($where, $tableName);
    }

    public function setTableName($tableName) {
        $this->tableName = $tableName;
        return $this;
    }

    public function getTableName() {
        return $this->tableName;
    }

    public function getEportalUserTable() {
        return $this->userTable;
    }

    public function setEportalUserTable($userTable) {
        $this->userTable = $userTable;
        return $this;
    }

    public function getEportalUserHydrator() {
        return $this->userHydrator;
    }

    public function setEportalUserHydrator(HydratorInterface $hydrator) {
        $this->userHydrator = $hydrator;
        return $this;
    }

    public function setEportalUserEntity(EportalUserInterface $user) {
        $this->userEntity = $user;
        return $this;
    }

    public function getEportalUserEntity() {
        return $this->userEntity;
    }

    public function getPropertyValueEntity() {
        return $this->propertyValueEntity;
    }

    public function setPropertyValueEntity(PropertyValueInterface $propertyValue) {
        $this->propertyValueEntity = $propertyValue;
        return $this;
    }

    public function setPropertyValueHydrator(HydratorInterface $hydrator) {
        $this->propertyValueHydrator = $hydrator;
        return $this;
    }

    public function getPropertyValueHydrator() {
        return $this->propertyValueHydrator;
    }

    public function setPropertyValueTable($pvTable){
        $this->propertyValueTable = $pvTable;
        return $this;
    }
    
}
