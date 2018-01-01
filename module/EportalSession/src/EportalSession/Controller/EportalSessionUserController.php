<?php

namespace EportalSession\Controller;

use EportalProperty\Controller\AbstractEportalPropertyUserController;
use EportalUser\Model\EportalUser;
use EportalUser\Service\UserSessionTermServiceInterface;
use Zend\Session\Container;

/**
 * @author OKALA
 */
class EportalSessionUserController extends AbstractEportalPropertyUserController {

    /**
     *
     * @var UserSessionTermServiceInterface
     */
    protected $userSessionTermService;

    public function __construct() {
        $this->sessionContainer = new Container('eportal_session');
    }
    
    public function getPropertyForm() {
        parent::getPropertyForm()
                ->getBaseFieldset()
                ->remove('school')
                ->remove('class')
                ->remove('department')
                ->remove('subject');
        return $this->propertyForm;
    }

    public function getUserSessionTermService() {
        if (!$this->userSessionTermService) {
            $this->userSessionTermService = $this->getServiceLocator()->get('EportalUser\Service\UserSessionTerm');
        }
        return $this->userSessionTermService;
    }

    public function setUserSessionTermService(UserSessionTermServiceInterface $userSessionTermService) {
        $this->userSessionTermService = $userSessionTermService;
        return $this;
    }

    protected function getUsers($property, $role) {
        $session = $property['session'];
        $term = $property['term'];
        $users = $this->getUserSessionTermService()->getUsers($session, $term, $role);
        $pvService = $this->getPropertyValueService();
        return [
            'users' => !$users ? [] : EportalUser::toArray($users),
            'role' => $role,
            'session' => $pvService->findById($session),
            'term' => $pvService->findById($term),
            'allow_add_students' => false,
            'allow_add' => false,
            'property' => 'session'
        ];
    }

}
