<?php

namespace EportalUser\Service;

use EportalUser\Mapper\EportalUserMapperInterface;
use EportalUser\Model\EportalUser;

/**
 *
 * @author imaleo
 */
class EportalUserService implements EportalUserServiceInterface{
    
    protected $mapper;
    
    public function __construct(EportalUserMapperInterface $mapper) {
        $this->mapper = $mapper;
    }
    
    public function findByEmail($email) {
        return $this->mapper->findByEmail($email);
    }

    public function findByGender($gender) {
        return $this->mapper->findByGender($gender);
    }

    public function findById($id) {
        return $this->mapper->findById($id);
    }

    public function findByUsername($username) {
        return $this->mapper->findByUsername($username);
    }

    public function getTotalGender($gender, $role = null) {
        return $this->mapper->getTotalGender($gender, $role);
    }

    public function getTotalUser($role = null) {
        return $this->mapper->getTotalUser($role);
    }

    public function insert($user) {
        return $this->mapper->insert($user);
    }

    public function update($user) {
        return $this->mapper->update($user);
    }

    public function setEportalUserMapper(EportalUserMapperInterface $mapper){
        $this->mapper = $mapper;
    }
    
    public function getEportalUserMapper(){
        return $this->mapper;
    }
    
    /**
     * 
     * @return EportalUser
     */
    public function getEntity() {
        return new EportalUser();
    }

    public function findByStatus($status) {
        return $this->mapper->findByStatus($status);
    }

}
