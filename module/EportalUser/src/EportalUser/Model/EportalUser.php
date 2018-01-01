<?php

namespace EportalUser\Model;

use ZfcUser\Entity\User;

/**
 * Description of EportalUser
 *
 * @author imaleo
 */
class EportalUser extends User implements EportalUserInterface {

    const MALE = '1';
    const FEMALE = '2';
    const STATUS_ACTIVE = 'active';
    const STATUS_EXPELLED = 'expelled';
    const STATUS_SUSPENDED = 'suspended';
    const STATUS_GRADUATED = 'graduated';
    const STATUS_INACTIVE = 'inactive';

    protected $firstName;
    protected $middleName = '';
    protected $lastName;
    protected $gender;
    protected $dob;
    protected $status = self::STATUS_ACTIVE;

    public function getFirstName() {
        return $this->firstName;
    }

    public function getMiddleName() {
        return $this->middleName;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function getGender() {
        return $this->gender;
    }

    public function getDob() {
        return $this->dob;
    }

    public function setFirstName($firstName) {
        $this->firstName = $firstName;
        return $this;
    }

    public function setMiddleName($middleName) {
        $this->middleName = $middleName;
        return $this;
    }

    public function setLastName($lastName) {
        $this->lastName = $lastName;
        return $this;
    }

    public function setGender($gender) {
        if ($gender == 'male' || $gender == 'm') {
            $gender = self::MALE;
        }
        if ($gender == 'female' || $gender == 'f') {
            $gender = self::FEMALE;
        }
        $this->gender = $gender;
        return $this;
    }

    public function setDob($dob) {
        $this->dob = $dob;
        return $this;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function fullName($capitalize = false) {
        $fullName = $this->getFirstName() . ' ' . $this->getMiddleName() . ' ' . $this->getLastName();
        if ($capitalize) {
            return strtoupper($fullName);
        }
        return ucwords($fullName);
    }

//    public function toArray() {
//        return [
//            'first_name' => $this->firstName,
//            'last_name' => $this->lastName,
//            'middle_name' => $this->middleName,
//            'username' => $this->username,
//            'fullname' => $this->fullName(),
//            'gender' => $this->gender,
//            'dob' => $this->dob,
//        ];
//    }

    
    private static function arr($user){
        return [
            'id' => $user->getId(),
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'middle_name' => $user->getMiddleName(),
            'username' => $user->getUsername(),
            'fullname' => $user->fullName(),
            'gender' => $user->getGender(),
            'dob' => $user->getDob(),
        ];
    }
    
    public static function toArray($users) {
        if ($users instanceof EportalUserInterface) {
            return self::arr($users);
        }
        if ($users instanceof \Traversable || is_array($users)) {
            $usersArr = [];
            foreach ($users as $user) {
                $usersArr[] = self::arr($user);
            }
            return $usersArr;
        }
        return null;
    }

}
