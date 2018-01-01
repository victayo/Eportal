<?php

namespace EportalClass\Controller;

use EportalClass\Service\EportalClassUserServiceInterface;
use EportalProperty\Controller\AbstractEportalPropertyUserController;
use EportalUser\Model\EportalUser;
use Zend\Session\Container;

/**
 * @author OKALA
 */
class EportalClassUserController extends AbstractEportalPropertyUserController {

    const ROUTE = 'zfcadmin/eportal-class-user';

    /**
     *
     * @var EportalClassUserServiceInterface
     */
    protected $eportalClassUserService;

    
    
    public function __construct() {
        $this->sessionContainer = new Container('eportal_class');
    }

    public function addAction() {
        /*
         * Students should not be added. A student should not be in two classes
         * at the same time in a session/term.
         * Only teachers can/should be added like this.
         */
        $role = $this->params()->fromRoute('user', null);
        if ($role === null) {
            return $this->notFoundAction();
        }
        $property = $this->sessionContainer->property;
        if(!$property){
            return $this->notFoundAction();
        }
        $session = $property['session'];
        $term = $property['term'];
        $school = $property['school'];
        $class = $property['class'];
        $service = $this->getEportalClassUserService();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $usersPost = $request->getPost()['user'];
            if ($usersPost) {
                foreach (array_keys($usersPost) as $user) {
                    $service->addUser($user, $session, $term, $school, $class);
                }
            }
            $this->sessionContainer->initialized = true;
            return $this->redirect()->toRoute(self::ROUTE, ['user' => $role]);
        }
        $pvService = $this->PropertyValue();
        $users = $service->getUnregisteredUsers($session, $term, $school, $class, $role);
        return [
            'users' => !$users ? [] : EportalUser::toArray($users),
            'role' => $role,
            'session' => $pvService->findById($session),
            'term' => $pvService->findById($term),
            'school' => $pvService->findById($school),
            'class' => $pvService->findById($class)
        ];
    }

    public function deleteAction() {
        
    }

    public function getPropertyForm() {
         parent::getPropertyForm()
                ->getBaseFieldset()
                    ->remove('department')
                    ->remove('subject');
         return $this->propertyForm;
    }

    public function getEportalClassUserService() {
        if (!$this->eportalClassUserService) {
            $this->eportalClassUserService = $this->getServiceLocator()->get('EportalClass\Service\EportalClassUser');
        }
        return $this->eportalClassUserService;
    }

    public function setEportalClassUserService(EportalClassUserServiceInterface $eportalClassUserService) {
        $this->eportalClassUserService = $eportalClassUserService;
        return $this;
    }
    
    protected function getUsers($property, $role) {
        $session = $property['session'];
        $term = $property['term'];
        $school = isset($property['school']) ? $property['school'] : null;
        $class = isset($property['class']) ? $property['class'] : null;
        $users = $this->getEportalClassUserService()->getUsers($session, $term, $school, $class, $role);
        $pvService = $this->PropertyValue();
        return [
            'users' => !$users ? [] : EportalUser::toArray($users),
            'role' => $role,
            'session' => $pvService->findById($session),
            'term' => $pvService->findById($term),
            'school' => $pvService->findById($school),
            'class' => $pvService->findById($class),
            'allow_add_student' => false,
            'allow_add' => true,
            'property' => 'class'
        ];
    }

}
