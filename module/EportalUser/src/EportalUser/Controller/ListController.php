<?php

namespace EportalUser\Controller;

use EportalProperty\Form\EportalPropertyForm;
use EportalRole\Model\UserRoleLinkerTable;
use EportalUser\Controller\AbstractUserController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

/**
 *
 * @author imaleo
 */
class ListController extends AbstractUserController {

    /**
     *
     * @var EportalPropertyForm
     */
    protected $propertyForm;

    /**
     *
     * @var UserRoleLinkerTable
     */
    protected $userRoleTable;

    public function indexAction() {
        $request = $this->getRequest();
        $role = $this->params()->fromRoute('user', 'student');
        $form = $this->getPropertyForm();
        if ($request->isPost()) {
            $post = $request->getPost();
            $property = $post['eportal_property'];
            $users = $this->getUsers($property, $role);
            return [
                'form' => $form,
                'users' => $users,
                'session' => $property['session'],
                'term' => $property['term'],
                'role' => $role
            ];
        }
        return new ViewModel(['form' => $form]);
    }

    protected function getUsers($property, $role) {
        $session = $property['session'];
        $term = $property['term'];
        $school = isset($property['school']) ? $property['school'] : null;
        $class = isset($property['class']) ? $property['class'] : null;
        $department = isset($property['department']) ? $property['department'] : null;
        $subject = isset($property['subject']) ? $property['subject'] : null;

        if ($school && $class && $department && $subject) {
            $service = $this->getServiceLocator()->get('EportalSubject\Service\EportalSubjectUser');
            $users = $service->getUsers($session, $term, $school, $class, $department, $subject, $role);
        } else if ($school && $class && $department) {
            $this->getDepartmentUser($session, $term, $class, $department);
            $service = $this->getServiceLocator()->get('EportalDepartment\Service\EportalDepartmentUser');
            $users = $service->getUsers($session, $term, $school, $class, $department, $role);
        } else if ($school && $class && $subject) {
            $this->getSubjectUser($session, $term, $school, $class, $subject);
        } else if ($school & $class) {
            return $this->redirect()->toRoute('zfcadmin/eportal-class-user', ['user'=>$role], ['query'=>['session'=>$session, 'term'=>$term, 'school'=>$school, 'class'=>$class]]);
        } else {
            $this->getSchoolUser($session, $term, $school);
            $service = $this->getServiceLocator()->get('EportalSchool\Service\EportalSchoolUser');
            $users = $service->getUsers($session, $term, $school, $role);
        }
        return !$users ? [] : $this->userToArray($users);
    }

    /**
     * 
     * @return ViewModel
     * @todo Ensure only authorized user view this action
     */
//    public function listAction() {
//        $form = $this->getPropertyForm();
//        $mainModel = new ViewModel(['form' => $form]);
//        $mainModel->setTemplate('eportal-user\list\index');
//        return $mainModel;
//    }
//    public function singleAction(){//or the role too is sent via query?
//        $query = $this->params()->fromQuery();
//        $user = $query['uid'];
//        $userRoleLinker = $this->getUserRoleLinkerTable();
//        $model = new ViewModel();
//        if($userRoleLinker->isRole($user, 'student')){
//            $var = $this->studentView($query);
//        }
//        if($userRoleLinker->isRole($user, 'teacher')){
////            $var = $this->teacherView($query);
//            $var = [];
//        }
//        $model->setVariables($var);
//        $model->setTemplate('eportal-user\list\single-student');
//        return $model;
//    }

    protected function getPropertyForm() {
        if (!$this->propertyForm) {
            $this->propertyForm = $this->getServiceLocator()->get('FormElementManager')->get('EportalProperty\Form\EportalProperty');
        }
        return $this->propertyForm;
    }

    protected function getUserRoleLinkerTable() {
        if (!$this->userRoleTable) {
            $this->userRoleTable = $this->getServiceLocator()->get('EportalRole\Service\UserRoleLinker');
        }
        return $this->userRoleTable;
    }

    protected function studentView($query) {
        $user = $this->getEportalUserService()->findById($query['uid']);
        $session = $this->getEportalPropertyValueService()->getPropertyValueService()->findById($query['session']);
        $term = $this->getEportalPropertyValueService()->getPropertyValueService()->findById($query['term']);
        $upvService = $this->getUserPropertyValueService();
        $school = $upvService->getSchool($user, $session, $term);
        $class = $upvService->getClass($user, $session, $term);
        $section = $upvService->getSection($user, $session, $term);
        $department = $upvService->getDepartment($user, $session, $term);
        $var = [
            'student' => $user,
            'eportal_class' => $class->current(),
            'school' => $school->current(),
            'section' => $section->current(),
            'department' => $department->current()
        ];
        return $var;
    }

    protected function teacherView($query) {
        $upvService = $this->getUserPropertyValueService();
        $session = $this->getEportalPropertyValueService()->getPropertyValueService()->findById($query['session']);
        $term = $this->getEportalPropertyValueService()->getPropertyValueService()->findById($query['term']);
        $term = $this->getEportalPropertyValueService()->getPropertyValueService()->findById($query['term']);
        $upvService->getSubjects($user, $session, $term);
    }

//    protected function getSchoolUser($query) {
    protected function getSchoolUser($session, $term, $school) {
//        $session = $query['sesid'];
//        $term = $query['tid'];
//        $school = $query['schid'];
        $service = $this->getServiceLocator()->get('EportalSchool\Service\EportalSchoolUser');
        $users = $service->getUsers($session, $term, $school);
        return [
            'users' => $this->userToArray($users),
            'success' => true
        ];
    }

//    protected function getClassUser($query) {
    protected function getClassUser($session, $term, $school, $class) {
//        $session = $query['sesid'];
//        $term = $query['tid'];
//        $school = $query['schid'];
//        $class = $query['cid'];
        $service = $this->getServiceLocator()->get('EportalClass\Service\EportalClassUser');
        $users = $service->getUsers($session, $term, $school, $class);
        return [
            'users' => !$users ? [] : $this->userToArray($users),
            'success' => true
        ];
    }

    protected function getDepartmentUser($query) {
        $session = $query['sesid'];
        $term = $query['tid'];
        $school = $query['schid'];
        $class = $query['cid'];
        $department = $query['did'];
        $service = $this->getServiceLocator()->get('EportalDepartment\Service\EportalDepartmentUser');
        $users = $service->getUsers($session, $term, $school, $class, $department);
        return [
            'users' => !$users ? [] : $this->userToArray($users),
            'success' => true
        ];
    }

    protected function getSubjectUser($query) {
        $session = $query['sesid'];
        $term = $query['tid'];
        $school = $query['schid'];
        $class = $query['cid'];
        $department = $query['did'];
        $subject = $query['subid'];
        $service = $this->getServiceLocator()->get('EportalSubject\Service\EportalSubjectUser');
        $users = $service->getUsers($session, $term, $school, $class, $department, $subject);
        return [
            'users' => !$users ? [] : $this->userToArray($users),
            'success' => true
        ];
    }

    private function userToArray($users) {
        return \EportalUser\Model\EportalUser::toArray($users);
//        $return = [];
//        foreach($users as $user){
//            $return[] = $user->toArray();
//        }
//        return $return;
    }

}
