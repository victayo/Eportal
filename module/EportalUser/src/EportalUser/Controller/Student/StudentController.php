<?php

namespace EportalUser\Controller\Student;

use EportalUser\Controller\AbstractUserController;
use Zend\View\Model\ViewModel;

/**
 *
 * @author imaleo
 */
class StudentController extends AbstractUserController {

    public function indexAction() {
        $id = $this->params()->fromQuery('id', 0);
//        $st = $this->params()->fromQuery('st', 0); //sessionTerm
        $session = $this->params()->fromQuery('session', 0);
        $term = $this->params()->fromQuery('term', 0);
//        if ($id && $st) {
//            return $this->viewSingle($id, $st);
//        }
//        if($st){
//            //return all users for this session term
//        }
//        if($id){//is this necessary
//            //return this user for all registered session term
//        }
        if($id && $session && $term){
            return $this->viewSingle($id, $session, $term);
        }
    }

    protected function viewSingle($id, $session, $term) {
        $userService = $this->getEportalUserService();
        $user = $userService->findByUsername($id);
        $upvService = $this->getUserPropertyValueService();
        $pvService = $this->getEportalPropertyValueService()->getPropertyValueService();
        $session = $pvService->findById($session);
        $term = $pvService->findById($term);
        return new ViewModel(array(
            'name' => $user->fullName(),
            'school' => $upvService->getSchool($user, $session, $term),
            'class' => $upvService->getClass($user, $session, $term),
            'section' => $upvService->getSection($user, $session, $term),
            'department' => $upvService->getDepartment($user, $session, $term),
            'status' => $user->getStatus($user)
        ));
    }
}
