<?php

namespace EportalClass\Controller;

use EportalClass\Service\EportalClassServiceInterface;
use EportalClass\Service\EportalClassUserServiceInterface;
use EportalProperty\Controller\AbstractEportalPropertyData;
use EportalUser\Model\EportalUser;
use Zend\View\Model\JsonModel;

/**
 * @author OKALA
 */
class EportalClassData extends AbstractEportalPropertyData{
    
    /**
     *
     * @var EportalClassServiceInterface
     */
    protected $eportalClassService;
    
    /**
     *
     * @var EportalClassUserServiceInterface
     */
    protected $eportalClassUserService;

    public function getDepartmentAction(){
        $query = $this->params()->fromQuery();
        $departments = isset($query['unregistered'])
                ? $this->getEportalClassService()->getUnaddedDepartment($query['school'], $query['class'])
                : $this->getEportalClassService()->getDepartments($query['school'], $query['class']);
        return new JsonModel($departments->toArray());
    }
    
    public function getSubjectAction(){
        $query = $this->params()->fromQuery();
        $subjects = isset($query['unregistered']) 
                ? $this->getEportalClassService()->getUnaddedSubjects($query['school'], $query['class'])
                : $this->getEportalClassService()->getSubjects($query['school'], $query['class']);
        return new JsonModel($subjects->toArray());
    }
    
    public function getUsersAction(){
        $query = $this->params()->fromQuery();
        $users = $this->getEportalClassUserService()->getUsers($query['session'], $query['term'], $query['school'], $query['class'], $query['role']);
        $var = !$users ? [] : EportalUser::toArray($users);
        return new JsonModel($var);
    }
    
    public function getEportalClassService() {
        return $this->eportalClassService;
    }

    public function getEportalClassUserService() {
        return $this->eportalClassUserService;
    }

    public function setEportalClassService(EportalClassServiceInterface $eportalClassService) {
        $this->eportalClassService = $eportalClassService;
        return $this;
    }

    public function setEportalClassUserService(EportalClassUserServiceInterface $eportalClassUserService) {
        $this->eportalClassUserService = $eportalClassUserService;
        return $this;
    }


}
