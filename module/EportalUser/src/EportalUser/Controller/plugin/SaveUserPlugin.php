<?php

namespace EportalUser\Controller\Plugin;

use Eportal\Controller\Plugin\AbstractEportalControllerPlugin;
use EportalClass\Service\EportalClassUserServiceInterface;
use EportalDepartment\Service\EportalDepartmentUserServiceInterface;
use EportalProperty\Model\EportalProperty;
use EportalSchool\Service\EportalSchoolUserServiceInterface;
use EportalUser\Service\UserSessionTermServiceInterface;
use Exception;
use ZfcUser\Service\User;

/**
 *
 * @author imaleo
 */
class SaveUserPlugin extends AbstractEportalControllerPlugin {

    const TEACHER = 'teacher';
    const STUDENT = 'student';

    /**
     *
     * @var UserSessionTermServiceInterface
     */
    protected $userSessionTerm;

    /**
     *
     * @var User
     */
    protected $userService;

    /**
     *
     * @var EportalSchoolUserServiceInterface
     */
    protected $schoolUserService;

    /**
     *
     * @var EportalClassUserServiceInterface
     */
    protected $classUserService;

    /**
     *
     * @var EportalDepartmentUserServiceInterface
     */
    protected $departmentUserService;

    /**
     * 
     * @param array $student
     * @param EportalProperty $property
     * @return boolean
     */
    public function save($user, $property, $role) {
        $this->beginTransaction();
        try {
            $session = $property['session'];
            $term = $property['term'];
            $user = $this->saveUser($user);
            if (!$user) {
                return false;
            }
            $ustEntity = $this->getUserSessionTermService()->getEntity()->setSession($session)
                    ->setTerm($term)
                    ->setUser($user);
            $this->getUserSessionTermService()->insert($ustEntity);
            $this->saveRole($user, $role);
            if ($role === self::STUDENT) {
                $this->saveStudent($user, $property);
            }
            $this->commit();
            return true;
        } catch (Exception $ex) {
            \Zend\Debug\Debug::dump($ex->getMessage(), 'MESSAGE');
            \Zend\Debug\Debug::dump($ex->getTraceAsString(), 'TRACE');
            $this->rollBack();
            return false;
        }
    }

    protected function saveStudent($student, $property) {
        $session = $property['session'];
        $term = $property['term'];
        $school = $property['school'];
        $class = $property['class'];
        $department = isset($property['department']) ? $property['department'] : null;
        $this->getSchoolUserService()->addUser($student, $session, $term, $school);
        $this->getClassUserService()->addUser($student, $session, $term, $school, $class);
        if ($department) {
            $this->getDepartmentUserService()->addUser($student, $session, $term, $school, $class, $department);
        }
    }

    protected function saveUser($user) {
        $user['password'] = strtolower($user['first_name']);
        $return = $this->getUserService()->register($user);
        if ($return) {
            return $return->getId();
        }
        return false;
    }

    protected function saveRole($user, $role) {
        $sl = $this->getController()->getServiceLocator();
        $roleTableGateway = $sl->get('BjyAuthorize\Service\RoleDbTableGateway');
        $userRoleLinkerService = $sl->get('EportalRole\Service\UserRoleLinker');
        $roleId = $roleTableGateway->select(['role_id' => $role])->current()->id;
        $userRoleLinkerEntity = $userRoleLinkerService->getEntity($user, $roleId);
        $userRoleLinkerService->save($userRoleLinkerEntity);
    }

    public function getUserService() {
        if (!$this->userService) {
            $this->userService = $this->getServiceLocator()->get('zfcuser_user_service');
        }
        return $this->userService;
    }

    public function setUserService(User $userService) {
        $this->userService = $userService;
        return $this;
    }

    public function getSchoolUserService() {
        if (!$this->schoolUserService) {
            $this->schoolUserService = $this->getServiceLocator()->get('EportalSchool\Service\EportalSchoolUser');
        }
        return $this->schoolUserService;
    }

    public function getClassUserService() {
        if (!$this->classUserService) {
            $this->classUserService = $this->getServiceLocator()->get('EportalClass\Service\EportalClassUser');
        }
        return $this->classUserService;
    }

    public function getDepartmentUserService() {
        if (!$this->departmentUserService) {
            $this->departmentUserService = $this->getServiceLocator()->get('EportalDepartment\Service\EportalDepartmentUser');
        }
        return $this->departmentUserService;
    }

    public function getUserSessionTermService() {
        if (!$this->userSessionTerm) {
            $this->userSessionTerm = $this->getServiceLocator()->get('EportalUser\Service\UserSessionTerm');
        }
        return $this->userSessionTerm;
    }

    public function setUserSessionTermService(UserSessionTermServiceInterface $userSessionTerm) {
        $this->userSessionTerm = $userSessionTerm;
        return $this;
    }

    public function setSchoolUserService(EportalSchoolUserServiceInterface $schoolUserService) {
        $this->schoolUserService = $schoolUserService;
        return $this;
    }

    public function setClassUserService(EportalClassUserServiceInterface $classUserService) {
        $this->classUserService = $classUserService;
        return $this;
    }

    public function setDepartmentUserService(EportalDepartmentUserServiceInterface $departmentUserService) {
        $this->departmentUserService = $departmentUserService;
        return $this;
    }

}
