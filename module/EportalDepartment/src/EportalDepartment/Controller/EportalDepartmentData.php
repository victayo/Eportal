<?php

namespace EportalDepartment\Controller;

use EportalDepartment\Service\EportalDepartmentServiceInterface;
use EportalDepartment\Service\EportalDepartmentUserServiceInterface;
use EportalProperty\Controller\AbstractEportalPropertyData;
use EportalUser\Model\EportalUser;
use Zend\View\Model\JsonModel;

/**
 * @author OKALA
 */
class EportalDepartmentData extends AbstractEportalPropertyData{
    
    /**
     *
     * @var EportalDepartmentServiceInterface
     */
    protected $eportalDepartmentService;
    
    /**
     *
     * @var EportalDepartmentUserServiceInterface
     */
    protected $eportalDepartmentUserService;
    
    public function getSubjectAction(){
        $query = $this->params()->fromQuery();
        $subjects = isset($query['unregistered']) 
                ? $this->getEportalDepartmentService()->getUnaddedSubject($query['scholl'], $query['class'], $query['department'])
                : $this->getEportalDepartmentService()->getSubject($query['school'], $query['class'], $query['department']);
        return new JsonModel($subjects->toArray());
    }

    public function getUserAction(){
        $query = $this->params()->fromQuery();
        $users = $this->getEportalDepartmentUserService()->getUsers($query['session'], $query['term'], $query['school'], $query['class'], $query['department'], $query['role']);
        $var = !$users ? [] : EportalUser::toArray($users);
        return new JsonModel($var);
    }
    
    public function getEportalDepartmentService() {
        if(!$this->eportalDepartmentService){
            $this->eportalDepartmentService = $this->getServiceLocator()->get('EportalDepartment\Service\EportalDepartment');
        }
        return $this->eportalDepartmentService;
    }

    public function getEportalDepartmentUserService() {
        if(!$this->eportalDepartmentUserService){
            $this->eportalDepartmentUserService = $this->getServiceLocator()->get('EportalDepartment\Service\EportalDepartmentUser');
        }
        return $this->eportalDepartmentUserService;
    }

    public function setEportalDepartmentService(EportalDepartmentServiceInterface $eportalDepartmentService) {
        $this->eportalDepartmentService = $eportalDepartmentService;
        return $this;
    }

    public function setEportalDepartmentUserService(EportalDepartmentUserServiceInterface $eportalDepartmentUserService) {
        $this->eportalDepartmentUserService = $eportalDepartmentUserService;
        return $this;
    }


}
