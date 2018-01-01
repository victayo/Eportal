<?php

namespace EportalUser\Mapper;

use ZfcUser\Mapper\User;

/**
 * Description of EportalUserMapper
 *
 * @author imaleo
 */
class EportalUserMapper extends User implements EportalUserMapperInterface {

    protected $tableName = 'eportal_user';

    public function findByGender($gender) {
        switch ($gender) {
            case 'male': $gender = 1;
                break;
            case 'female': $gender = 2;
                break;
        }
        $select = $this->getSelect()
                ->where(['gender = ?' => $ng]);
        return $this->select($select);
    }

    public function findByStatus($status) {
        $select = $this->getSelect()
                ->where(['status = ?' => $status]);
        return $this->select($select);
    }

    public function getTotalUser($role = null) {
        if (!$role) {
            return $this->select($this->getSelect())->count();
        }
        $select = $this->getSelect()
                ->join('user_role_linker', 'user_role_linker.user_id = eportal_user.user_id')
                ->join('user_role', 'user_role.id = user_role_linker.role_id')
                ->where(['user_role.role_id' => $role]);
        return $this->select($select)->count();
    }

    public function getTotalGender($gender, $role = null) {
        if (!$role) {
            return $this->findByGender($gender)->count();
        }
        switch ($gender) {
            case 'male': $gender = 1;
                break;
            case 'female': $gender = 2;
                break;
        }
        $select = $this->getSelect()
                ->join('user_role_linker', 'user_role_linker.user_id = eportal_user.user_id')
                ->join('user_role', 'user_role.id = user_role_linker.role_id')
                ->where([
            'user_role.role_id' => $role,
            'gender' => $gender
        ]);
        return $this->select($select)->count();
    }

}
