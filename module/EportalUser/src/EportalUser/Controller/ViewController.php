<?php

namespace EportalUser\Controller;

use EportalUser\Model\EportalUser;

/**
 * @author OKALA
 */
class ViewController extends AbstractUserController{
    
    public function indexAction() {
        $id = $this->params()->fromRoute('id', null);
        $query = $this->params()->fromQuery();
        return $this->getUser($id, $query);
    }
    
    protected function getUser($user_id, $query) {
        $session = isset($query['session']) ? $query['session'] : $this->getEportalSettingService()->getActiveSession();
        $term = isset($query['term']) ? $query['term'] : $this->getEportalSettingService()->getActiveTerm();
        $user = $this->getEportalUserService()->findById($user_id);
        if (!$user) {
            return [];
        }
        $eportalPropertyUserService = $this->getServiceLocator()->get('EportalProperty\Service\EportalPropertyUser');
        $school = $eportalPropertyUserService->getSchool($user_id, $session, $term);
        $class = $eportalPropertyUserService->getClass($user_id, $session, $term);
        $department = $eportalPropertyUserService->getDepartment($user_id, $session, $term);
        $subject = $eportalPropertyUserService->getSubject($user_id, $session, $term);

        return [
            'user' => EportalUser::toArray($user),
            'school' => $school,
            'class' => $class,
            'department' => $department,
            'subject' => $subject,
        ];
    }
}
