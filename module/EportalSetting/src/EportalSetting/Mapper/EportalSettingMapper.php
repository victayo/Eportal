<?php

namespace EportalSetting\Mapper;

use Zend\Stdlib\Hydrator\HydratorInterface;
use ZfcBase\Mapper\AbstractDbMapper;

/**
 *
 * @author imaleo
 */
class EportalSettingMapper extends AbstractDbMapper{
    protected $tableName = 'eportal_setting';
    
    public function getMetaValue($meta){
        $select = $this->getSelect()
                ->where(array(
                    'meta = ?' => $meta
                ));
        $result = $this->select($select);
        if($result->count()){
            return $result->current();
        }
        return null;
    }
    
    public function save($entity){
        $meta = $entity->getMeta();
        if($this->getMetaValue($meta)){
            $this->update($entity);
        }else{
            $this->insert($entity);
        }
        return $entity;
    }
    
    protected function update($entity, $where = null, $tableName = null, HydratorInterface $hydrator = null) {
        if(!$where){
            $where = array(
                'meta = ?' => $entity->getMeta()
            );
        }
        return parent::update($entity, $where, $tableName, $hydrator);
    }
}
