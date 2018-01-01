<?php

namespace EportalUser\Service;

use EportalUser\Model\EportalUserInterface;

/**
 *
 * @author imaleo
 */
class EportalUserUtilService {

    public function usersToArray($users) {
        $arr = [];
        foreach ($users as $user) {
            $arr[] = $this->toArray($user);
        }
        return $arr;
    }

    public function toArray(EportalUserInterface $user) {
        if ($user->getGender() == 1) {
            $gender = 'male';
        } else {
            $gender = 'female';
        }
        $return = [
            'id' => $user->getId(),
            'firstName' => $user->getFirstName(),
            'middleName' => $user->getMiddleName(),
            'lastName' => $user->getLastName(),
            'fullname' => $user->fullName(),
            'username' => $user->getUsername(),
            'dob' => $user->getDob(),
            'status' => $user->getStatus(),
            'gender' => $gender
        ];
        return $return;
    }

}
