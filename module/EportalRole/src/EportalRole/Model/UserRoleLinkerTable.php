<?php

namespace EportalRole\Model;

use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;

/**
 *
 * @author imaleo
 */
class UserRoleLinkerTable {

    /**
     *
     * @var TableGateway
     */
    protected $tableGateway;

    /**
     *
     * @var Select
     */
    protected $select;
    public function __construct($tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function save(UserRoleLinker $userRoleLinker) {
        $data = [
            'user_id' => $userRoleLinker->getUser(),
            'role_id' => $userRoleLinker->getRole()
        ];
        /*
         * check if $userRoleLinker already exist. This is to be expected when registering staff and students
         * for a new session &/ term. so do nothing.
         */
        $row = $this->tableGateway->select(['user_id' => $data['user_id'], 'role_id' => $data['role_id']]);
        if ($row->count()) {
            return;
        }
        $this->tableGateway->insert($data);
    }

    public function delete(UserRoleLinker $userRoleLinker) {
        $this->tableGateway->delete(['user_id' => $userRoleLinker->getUser(), 'role_id' => $userRoleLinker->getRole()]);
    }

    public function getEntity($user = null, $role = null) {
        return new UserRoleLinker($user, $role);
    }

    public function getRole($user) {
        $select = $this->getSelect()
                ->join('user_role', 'user_role_linker.role_id = user_role.id', ['role_id'])
                ->join('eportal_user', 'eportal_user.user_id = user_role_linker.user_id', [])
                ->where(['eportal_user.user_id = ?' => $user])
                ->columns([]);
        /*
         * could have returned $this->tableGateway->selectWith($select)->current() but some users
         * may have more than one role
         */
        return $this->tableGateway->selectWith($select);
    }
    
    public function isRole($user, $role){
        $select = $this->getSelect()
                ->join('user_role', 'user_role_linker.role_id = user_role.id', [])
                ->where(['user_id' => $user, 'user_role.role_id' => $role]);
        $row = $this->tableGateway->selectWith($select);
        return boolval($row->count());
    }
    
    public function getSelect($tablename = null){
        if(!$tablename){
            $tablename = 'user_role_linker';
        }
        return new Select($tablename);
    }
}
