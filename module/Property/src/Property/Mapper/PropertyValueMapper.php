<?php

namespace Property\Mapper;

/**
 *
 * @author imaleo
 *        
 */
class PropertyValueMapper extends AbstractPropertyDbMapper implements PropertyValueMapperInterface {

    protected $tableName = 'property_value';

    public function findAll() {
        $select = $this->getSelect()
                ->order('property ASC', 'value ASC');
        return $this->select($select);
    }

    public function findById($id) {
        $select = $this->getSelect()->where(['id = ?' => $id]);
        return $this->select($select)->current();
    }

    public function findByProperty($property) {
        $select = $this->getSelect()
                ->where(['property = ?' => $property])
                ->order('value ASC');
        return $this->select($select);
    }

    public function getId($property, $value) {
        $select = $this->getSelect()->where([
            'property = ?' => $property,
            'value = ?' => $value
        ]);
        $result = $this->select($select);
        if ($result->count() == 0) {
            return null;
        }
        return $result->current();
    }

}
