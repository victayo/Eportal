<?php

namespace EportalUser\Mapper;
/**
 *
 * @author imaleo
 *        
 */
class UserPropertyValueMapper extends EportalAbstractDbMapper implements UserPropertyValueMapperInterface {

    protected $tableName = 'user_property_value';

    /**
     *
     * @see UserPropertyValueMapperInterface::getPropertyValues()
     *
     */
    public function getPropertyValues($user, $session, $term, $property = null) {
        $where = array(
            'user = ?' => $user,
            'session = ?' => $session,
            'term = ?' => $term,
        );
        if ($property) {
            $where['property'] = $property;
        }
        $select = $this->getSelect()
                ->join($this->ustTable, $this->ustTable . '.id = ' . $this->tableName . '.user_session_term', [])
                ->join($this->propertyValueTable, $this->propertyValueTable . '.id = ' . $this->tableName . '.property_value')
                ->where($where)
                ->order(['property ASC', 'value ASC'])
                ->columns([]);
        /**
         * @todo throw Exception if either $pvEntity or $pvHydrator is Null
         */
        return $this->select($select, $this->getPropertyValueEntity(), $this->getPropertyValueHydrator());
    }

    /**
     *
     * @see UserPropertyValueMapperInterface::hasPropertyValue()
     *
     */
    public function getUserPropertyValue($user, $propertyValue, $session, $term) {
        $select = $this->getSelect()
                ->join($this->ustTable, $this->tableName . '.user_session_term = ' . $this->ustTable . '.id', [])
                ->where([
            'user = ?' => $user,
            'property_value = ?' => $propertyValue,
            'session = ?' => $session,
            'term = ?' => $term,
        ]);
        return $this->select($select);
    }

    /**
     *
     * @see UserPropertyValueMapperInterface::getUsers()
     *
     */
    public function getUsers($session, $term, $propertyValue, $role = null) {
        $select = $this->getSelect()
                ->join($this->ustTable, $this->ustTable . '.id = ' . $this->tableName . '.user_session_term', [])
                ->join($this->userTable, $this->ustTable . '.user = user_id');

        $where = ['session = ?' => $session,
            'term = ?' => $term,
            'property_value' => $propertyValue,
        ];
        if ($role) {
            $select->join('user_role_linker', 'user_role_linker.user_id = eportal_user.user_id', [])
                    ->join('user_role', 'user_role.id = user_role_linker.role_id', []);
            $where['user_role.role_id'] = $role;
        }
        $select->where($where)
                ->columns([]);

        if (is_array($propertyValue)) {
            $select->group($this->userTable . '.user_id')
            ->having->expression("count(" . $this->tableName . ".property_value) = ?", [count($propertyValue)]);
        }
        $return = $this->select($select, $this->getEportalUserEntity(), $this->getEportalUserHydrator());
        return $return;
    }
    
    public function getSubjects($user, $session, $term){
        $select = $this->getSelect(['upv1' => 'user_property_value'])
                ->join(['upv_2' => 'user_property_value', 'upv1.id = upv2.parent'], [], \Zend\Db\Sql\Select::JOIN_LEFT)
            ->join('user_session_term', 'user_session_term.id = upv1.user_session_term', [])
            ->join('eportal_user', 'eportal_user.user_id = user_session_term.user', [])
            ->where([
                'eportal_user.user_id' => $user,
                'session' => $session,
                'term' => $term,
                'upv2.id' => null,
                'upv1.property_value' => new Expression($this->getArrayPropertyValue('subject')),
            ])
            ->columns([]);
        return $this->select($select, $this->getPropertyValueHydrator(), $this->getPropertyValueEntity());
    }
    
    public function getSubjectUsers($session, $term, $subject){
        $select = $this->getSelect(['upv1' => 'user_property_value'])
                ->join(['upv_2' => 'user_property_value', 'upv1.id = upv2.parent'], [], \Zend\Db\Sql\Select::JOIN_LEFT)
            ->join('user_session_term', 'user_session_term.id = upv1.user_session_term', [])
            ->join('eportal_user', 'eportal_user.user_id = user_session_term.user', [])
            ->where([
                'session' => $session,
                'term' => $term,
                'upv2.id' => null,
                'upv1.property_value' => $subject,
            ])
            ->columns([]);
        return $this->select($select, $this->getEportalUserHydrator(), $this->getEportalUserEntity());
    }
    
    protected function getArrayPropertyValue($property){
        $select = $this->getSelect('property_value')
                ->join('property', 'property_value.property = property.id', [])
                ->where(['property.name' => $property])
                ->columns(['id']);
//        $rows = $this->select($select, $this->getPropertyValueHydrator(), $this->getPropertyValueEntity());
//        $ids = [];
//        foreach($rows as $row){
//            $ids[] = $row->getId();
//        }
//        return $ids;
        return $this->getSql()->getSqlStringForSqlObject($select);
    }
    public function getUnregisteredUsers($session, $term, $propertyValue, $role){
        
    }
}
