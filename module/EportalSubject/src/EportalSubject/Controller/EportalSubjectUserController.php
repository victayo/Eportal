<?php

namespace EportalSubject\Controller;

use EportalProperty\Form\EportalPropertyForm;
use EportalSubject\Service\EportalSubjectUserServiceInterface;
use EportalUser\Model\EportalUser;
use Property\Service\PropertyValueServiceInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

/**
 * @author OKALA
 */
class EportalSubjectUserController extends \EportalProperty\Controller\AbstractEportalPropertyUserController{
    
    /**
     *
     * @var EportalSubjectUserServiceInterface
     */
    protected $eportalSubjectUserService;
    
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
    
    
    
    public function __construct() {
        $this->sessionContainer = new Container('eportal_subject');
    }
    
    public function addAction() {
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
        $department = $property['department'];
        $subject = $property['subject'];
        $service = $this->getEportalSubjectUserService();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $usersPost = $request->getPost()['user'];
            if ($usersPost) {
                foreach (array_keys($usersPost) as $user) {
                    $service->addUser($user, $session, $term, $school, $class, $department, $subject);
                }
            }
            $this->sessionContainer->initialized = true;
            return $this->redirect()->toRoute(self::ROUTE, ['user' => $role]);
        }
        $pvService = $this->PropertyValue();
        $users = $service->getUnregisteredUsers($session, $term, $school, $class, $department, $subject, $role);
        return [
            'users' => !$users ? [] : EportalUser::toArray($users),
            'role' => $role,
            'session' => $pvService->findById($session),
            'term' => $pvService->findById($term),
            'school' => $pvService->findById($school),
            'class' => $pvService->findById($class),
            'department' => $pvService->findById($department),
            'subject' => $pvService->findById($subject)
        ];
    }
    
    public function getEportalSubjectUserService() {
        if (!$this->eportalSubjectUserService) {
            $this->eportalSubjectUserService = $this->getServiceLocator()->get('EportalSubject\Service\EportalSubjectUser');
        }
        return $this->eportalSubjectUserService;
    }

    public function setEportalSubjectUserService(EportalSubjectUserServiceInterface $eportalSubjectUserService) {
        $this->eportalSubjectUserService = $eportalSubjectUserService;
        return $this;
    }
    
    protected function getUsers($property, $role) {
        $session = $property['session'];
        $term = $property['term'];
        $school = isset($property['school']) ? $property['school'] : null;
        $class = isset($property['class']) ? $property['class'] : null;
        $department = isset($property['department']) ? $property['department'] : null;
        $subject = isset($property['subject']) ? $property['subject'] : null;
        $users = $this->getEportalSubjectUserService()->getUsers($session, $term, $school, $class, $department, $subject, $role);
        $pvService = $this->PropertyValue();
        return [
            'users' => !$users ? [] : EportalUser::toArray($users),
            'role' => $role,
            'session' => $pvService->findById($session),
            'term' => $pvService->findById($term),
            'school' => $pvService->findById($school),
            'class' => $pvService->findById($class),
            'subject' => $pvService->findById($subject),
            'allow_add_students' => true,
            'allow_add' => true,
            'property' => 'subject'
        ];
    }
}
