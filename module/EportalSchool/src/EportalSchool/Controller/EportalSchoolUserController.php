<?php

namespace EportalSchool\Controller;

use EportalProperty\Controller\AbstractEportalPropertyUserController;
use EportalProperty\Form\EportalPropertyForm;
use EportalSchool\Service\EportalSchoolUserServiceInterface;
use EportalUser\Model\EportalUser;
use Property\Service\PropertyValueServiceInterface;
use Zend\Session\Container;

/**
 * @author OKALA
 */
class EportalSchoolUserController extends AbstractEportalPropertyUserController{
    /**
     *
     * @var EportalSchoolUserServiceInterface
     */
    protected $eportalSchoolUserService;
    
    /**
     *
     * @var Container
     */
    protected $sessionContainer;
    
    /**
     *
     * @var PropertyValueServiceInterface
     */
    protected $propertyValueService;
    
    /**
     *
     * @var EportalPropertyForm
     */
    protected $propertyForm;
    
    public function __construct() {
        $this->sessionContainer = new Container('eportal_school');
    }
    
     public function getPropertyForm() {
        parent::getPropertyForm()
                ->getBaseFieldset()
                    ->remove('class')
                    ->remove('department')
                    ->remove('subject');
        return $this->propertyForm;
    }

    public function getEportalSchoolUserService() {
        if (!$this->eportalSchoolUserService) {
            $this->eportalSchoolUserService = $this->getServiceLocator()->get('EportalSchool\Service\EportalSchoolUser');
        }
        return $this->eportalSchoolUserService;
    }

    public function setEportalSchoolUserService(EportalSchoolUserServiceInterface $eportalSchoolUserService) {
        $this->eportalSchoolUserService = $eportalSchoolUserService;
        return $this;
    }
    
    protected function getUsers($property, $role) {
        $session = $property['session'];
        $term = $property['term'];
        $school = isset($property['school']) ? $property['school'] : null;
        $users = $this->getEportalSchoolUserService()->getUsers($session, $term, $school, $role);
        $pvService = $this->PropertyValue();
        return [
            'users' => !$users ? [] : EportalUser::toArray($users),
            'role' => $role,
            'session' => $pvService->findById($session),
            'term' => $pvService->findById($term),
            'school' => $pvService->findById($school),
            'allow_add_students' => false,
            'allow_add' => false,
            'property' => 'school'
        ];
    }
}
