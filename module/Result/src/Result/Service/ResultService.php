<?php

namespace Result\Service;

use Result\Mapper\ResultMapperInterface;
use Result\Model\Result;
use Result\Model\ResultInterface;
use Result\Service\ResultServiceInterface;
/**
 * Description of ResultService
 *
 * @author imaleo
 */
class ResultService implements ResultServiceInterface {

    /**
     *
     * @var ResultMapperInterface 
     */
    protected $mapper;

    public function __construct(ResultMapperInterface $mapper) {
        $this->mapper = $mapper;
    }

    public function getEntity(){
        return new Result();
    }
    
    public function findById($result_id) {
        return $this->mapper->findById($result_id);
    }

    public function getResult($user, $session, $term, $subject = null) {
        return $this->mapper->getResult($user, $session, $term, $subject);
    }

    public function getSubjects($user, $session, $term) {
        return $this->mapper->getSubjects($user, $session, $term);
    }

    public function getTerm($user, $session, $subject) {
        return $this->mapper->getTerm($user, $subject, $session);
    }

    public function getUsers($session, $term, $subject) {
        return $this->mapper->getUsers($session, $term, $subject);
    }

    public function hasSubject($user, $session, $term, $subject) {
        $x = $this->getResult($user, $session, $term, $subject);
        return boolval($x);
    }

    public function getMapper() {
        return $this->mapper;
    }

    public function setMapper(ResultMapperInterface $mapper) {
        $this->mapper = $mapper;
        return $this;
    }

    public function delete(ResultInterface $result, $where = null) {
        if (!$where) {
            $where = ['id = ?' => $result->getId()];
        }
        return $this->mapper->delete($where);
    }

    public function insert(ResultInterface $result) {
        return $this->mapper->insert($result);
    }

    public function update(ResultInterface $result, $where = null) {
        if (!$where) {
            $where = ['id = ?' => $result->getId()];
        }
        return $this->mapper->update($result, $where);
    }

}
