<?php

namespace EportalUser\Mapper;

/**
 *
 * @author imaleo
 *        
 */
class UserSessionTermMapper extends EportalAbstractDbMapper implements UserSessionTermMapperInterface {

    protected $tableName = 'user_session_term';
    
    public function getUserSessionTerm($user, $session, $term) {
        $select = $this->getSelect()
                ->where([
                    'user = ?' => $user,
                    'session = ?' => $session,
                    'term = ?' => $term
                ]);
        return $this->select($select)->current();
    }

    public function findById($id) {
        $select = $this->getSelect()->where(array('id = ?' => $id));
        return $this->select($select)->current();
    }

    /**
     *
     * @see UserSessionTermMapperInterface::getSessionTerms()
     *
     */
    public function getSessionTerms($user) {
        $select = $this->getSelect()
                ->where(array('user = ?' => $user))
                ->columns(array());
        return $this->select($select);
    }

    /**
     *
     * @see UserSessionTermMapperInterface::exist()
     *
     */
    public function exist($user, $session, $term) {
        $select = $this->getSelect()->where(array(
            'user = ?' => $user,
            'session = ?' => $session,
            'term = ?' => $term
        ));
        return boolval($this->select($select)->count());
    }

    /**
     *
     * @see UserSessionTermMapperInterface::getUsers()
     *
     */
    public function getUsers($session, $term, $role = null) {
        $where = [
            'session = ?' => $session,
            'term = ?' => $term
        ];
        $select = $this->getSelect()->join($this->userTable, 'user_id = ' . $this->tableName . '.user');
        if($role){
            $select->join('user_role_linker', 'user_role_linker.user_id = eportal_user.user_id', [])
                    ->join('user_role', 'user_role.id = user_role_linker.role_id', []);
            $where['user_role.role_id'] = $role;
        }
        $select->where($where)->columns([]);
        return $this->select($select, $this->getEportalUserEntity(), $this->getEportalUserHydrator());
    }
}
