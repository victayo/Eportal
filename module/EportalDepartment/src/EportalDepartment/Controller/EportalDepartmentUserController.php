<?php

namespace EportalDepartment\Controller;

use EportalDepartment\Service\EportalDepartmentUserServiceInterface;
use EportalProperty\Controller\AbstractEportalPropertyUserController;
use EportalUser\Model\EportalUser;
use Zend\Session\Container;

/**
 * @author OKALA
 */
class EportalDepartmentUserController extends AbstractEportalPropertyUserController{
    
    /**
     *
     * @var EportalDepartmentUserServiceInterface
     */ 
    protected $eportalDepartmentUserService;
    
    public function __construct() {
        $this->sessionContainer = new Container('eportal_department');
    }

    public function getPropertyForm() {
        parent::getPropertyForm()
                ->getBaseFieldset()
                ->remove('subject');
        return $this->propertyForm;
    }
    
    public function getEportalDepartmentUserService() {
        if (!$this->eportalDepartmentUserService) {
            $this->eportalDepartmentUserService = $this->getServiceLocator()->get('EportalDepartment\Service\EportalDepartmentUser');
        }
        return $this->eportalDepartmentUserService;
    }

    public function setEportalDepartmentUserService(EportalDepartmentUserServiceInterface $eportalDepartmentUserService) {
        $this->eportalDepartmentUserService = $eportalDepartmentUserService;
        return $this;
    }
    
    protected function getUsers($property, $role) {
        $session = $property['session'];
        $term = $property['term'];
        $school = isset($property['school']) ? $property['school'] : null;
        $class = isset($property['class']) ? $property['class'] : null;
        $department = isset($property['department']) ? $property['department'] : null;
        $users = $this->getEportalDepartmentUserService()->getUsers($session, $term, $school, $class, $department, $role);
        $pvService = $this->getPropertyValueService();
        return [
            'users' => !$users ? [] : EportalUser::toArray($users),
            'role' => $role,
            'session' => $pvService->findById($session),
            'term' => $pvService->findById($term),
            'school' => $pvService->findById($school),
            'allow_add_students' => false,
            'allow_add' => false,
            'property' => 'department'
        ];
    }

}
