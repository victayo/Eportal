<?php

namespace EportalSchool\Controller;

use EportalProperty\Controller\AbstractEportalPropertyData;
use EportalSchool\Service\EportalSchoolServiceInterface;
use EportalSchool\Service\EportalSchoolUserServiceInterface;
use EportalUser\Model\EportalUser;
use Zend\View\Model\JsonModel;

/**
 * @author OKALA
 */
class EportalSchoolData extends AbstractEportalPropertyData{
    
    /**
     *
     * @var EportalSchoolServiceInterface
     */
    protected $eportalSchoolService;
    
    /**
     *
     * @var EportalSchoolUserServiceInterface
     */
    protected $eportalSchoolUserService;
    public function getClassAction(){
        $query = $this->params()->fromQuery();
        $classes = isset($query['unregistered'])
                ? $this->getEportalSchoolService()->getUnmappedClasses($query['school'])
                : $this->getEportalSchoolService()->getClasses($query['school']);
        return new JsonModel($classes->toArray());
    }
    
    public function getUsersAction(){
        $query = $this->params()->fromQuery();
        $users = $this->getEportalSchoolUserService()->getUsers($query['session'], $query['term'], $query['school'], $query['role']);
        $var = !$users ? [] : EportalUser::toArray($users);
        return new JsonModel($var);
    }
    
    public function getEportalSchoolService() {
        if(!$this->eportalSchoolService){
            $this->eportalSchoolService = $this->getServiceLocator()->get('EportalSchool\Service\EportalSchool');
        }
        return $this->eportalSchoolService;
    }

    public function getEportalSchoolUserService() {
        if(!$this->eportalSchoolUserService){
            $this->eportalSchoolUserService = $this->getServiceLocator()->get('EportalSchool\Service\EportalSchoolUser');
        }
        return $this->eportalSchoolUserService;
    }

    public function setEportalSchoolUserService(EportalSchoolUserServiceInterface $eportalSchoolUserService) {
        $this->eportalSchoolUserService = $eportalSchoolUserService;
        return $this;
    }

        public function setEportalSchoolService(EportalSchoolServiceInterface $eportalSchoolService) {
        $this->eportalSchoolService = $eportalSchoolService;
        return $this;
    }


}
