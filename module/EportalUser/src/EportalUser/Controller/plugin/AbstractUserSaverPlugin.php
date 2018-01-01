<?php

namespace EportalUser\Controller\Plugin;

use Eportal\Controller\Plugin\AbstractEportalControllerPlugin;
use Zend\Crypt\Password\Bcrypt;

/**
 *
 * @author imaleo
 */
abstract class AbstractUserSaverPlugin extends AbstractEportalControllerPlugin {


    abstract public function save($user, $property);

    protected function insertUser($user) {
        $this->setPassword($user);
        $this->getController()->getEportalUserService()->insert($user);
        return $user;
    }

    protected function map($user, $property) {
        $controller = $this->getController();
        $propertyValueService = $controller->getEportalPropertyValueService()->getPropertyValueService();
        $ejpvService = $controller->getEportaRelPropertyValueService();
        
        $rupvService = $controller->getRelUserPropertyValueService();
        
        $session = $property->getSession();
        $term = $property->getTerm();
        $ustService = $controller->getUserSessionTermService();
        $ustEntity = $ustService->getEntity();
        $ustEntity->setUser($user->getId())
                ->setSession($session)
                ->setTerm($term);
        
        $ustService->insert($ustEntity);
        
        $rupvEntity = $rupvService->getEntity();
        
        $ustId = $ustEntity->getId();
        $classId = $property->getClass();
        $class = $propertyValueService->findById($classId);
        $school = $ejpvService->getSchool($class)->current();
        $department = $property->getDepartment();
        $classSubjects = $ejpvService->getSubject($class);
        
        $relSch = $this->userPropertyValueInsert($ustId, $school->getId());
        $relClass = $this->userPropertyValueInsert($ustId, $classId);
        
        if($this->isStaff($user)){
        $rupvEntity->setParent(null)
                ->setUserPropertyValue($relSch->getId());
        $rupvService->insert($rupvEntity);
        $rupvEntity->setParent($relSch->getId())
                ->setUserPropertyValue($relClass->getId());
        $rupvService->insert($rupvEntity);
        }
        
        if (!$department) {//register user under general department
            $deptProp = $controller->getEportalPropertyService()->getPropertyService()->findByName('department');
            $department = $propertyValueService->getId($deptProp, 'general');
            $this->userPropertyValueInsert($ustId, $department);
        } else {//get departmental subjects, register user with subjects
            $relDept = $this->userPropertyValueInsert($ustId, $department);
            
            $rupvEntity->setParent($relClass->getId())
                    ->setUserPropertyValue($relDept->getId());
            $rupvService->insert($rupvEntity);
            
            $deptPv = $propertyValueService->findById($department);
            $deptSubjects = $ejpvService->getSubject($deptPv);
            
//            $this->removeDuplicates($deptSubjects, $classSubjects);
            
            foreach ($deptSubjects as $deptSubject) {
                $relDeptSub = $this->userPropertyValueInsert($ustId, $deptSubject->getId());
                $rupvEntity->setParent($relDept->getId())
                        ->setUserPropertyValue($relDeptSub);
                $rupvService->insert($rupvEntity);
            }
        }
        $settingService = $controller->getSettingService();
        if ($settingService->getHasSection()) {
            $section = $property->getSection();
            $this->userPropertyValueInsert($ustId, $section);
        }
        
        foreach ($classSubjects as $subject) {//register class subjects with user
            $relClassSub = $this->userPropertyValueInsert($ustId, $subject->getId());
            $rupvEntity->setParent($relClass->getId())
                        ->setUserPropertyValue($relClassSub);
                $rupvService->insert($rupvEntity);
        }
    }

    private function setPassword($user) {
        $lastname = strtolower($user->getLastName());
        $bcrypt = new Bcrypt;
        $bcrypt->setCost(14);
        $pass = $bcrypt->create($lastname);
        $user->setPassword($pass);
    }

    private function setDisplayName($user) {
        $firstname = $user->getFirstName();
        $middlename = !$user->getMiddleName() ? '' : $user->getMiddleName();
        $lastname = $user->getLastName();
        $displayname = $firstname . ' ' . $middlename . ' ' . $lastname;
        $user->setDisplayName($displayname);
    }

    private function userPropertyValueInsert($ust, $propertyValue) {
        if (!$propertyValue) {
            return null;
        }
        $upvService = $this->getController()->getUserPropertyValueService();
        $entity = $upvService->getEntity();
        $entity->setRelPropertyValue($propertyValue)
                ->setUserSessionTerm($ust);
        return $upvService->insert($entity);
    }

    private function removeDuplicates(&$deptSub, &$classSub){
        for($i= 0, $l = count($classSub); $i<$l; $i++){
            for($j = 0, $lj = count($deptSub); $j<$lj; $j++){
                if($classSub[$i]->getId() == $deptSub[$j]->getId()){
                    unset($deptSub[$j]);
                }
            }
        }
    }
    
    protected function isStaff($user){
        return true;
    }
}
