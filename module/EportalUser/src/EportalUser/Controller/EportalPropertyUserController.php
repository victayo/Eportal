<?php

namespace EportalUser\Controller;

use EportalProperty\Form\EportalPropertyForm;
use EportalUser\Service\EportalUserUtilService;
use EportalUser\Service\Property\EportalPropertyUser;
use EportalUser\Service\Property\EportalSessionTermUser;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

/**
 *
 * @author imaleo
 */
class EportalPropertyUserController extends AbstractActionController {

    /**
     *
     * @var EportalUserUtilService
     */
    protected $userUtilService;

    /**
     *
     * @var EportalPropertyUser
     */
    protected $eportalPropertyUser;

    /**
     *
     * @var EportalSessionTermUser
     */
    protected $sessionTermService;

    /**
     *
     * @var EportalPropertyForm
     */
    protected $propertyForm;
    public function indexAction() {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = json_decode($request->getContent(), TRUE);
            $property = $data['property'];
            $session = $data['session'];
            $term = $data['term'];
            $role = array_key_exists('role', $data) ? $data['role'] : null;
            if (!count($property)) {
                $users = $this->getEportalSessionTermUserService()->getUsers($session, $term, $role);
            } else {
                $users = $this->getEportalPropertyUser()->getUsers($session, $term, $property, $role);
            }
            $var = [
                'users' => $this->getEportalUserUtil()->usersToArray($users),
                'success' => true
            ];
            return new JsonModel($var);
        }
    }

    public function classTeacherAction() {
        $form = $this->getPropertyForm('class');
        return ['form' => $form];
    }

    public function subjectTeacherAction() {
        
    }

    public function sectionTeacherAction() {
        
    }

    protected function getPropertyForm($property){
        if(!$this->propertyForm){
            $this->propertyForm = $this->getServiceLocator()->get('FormElementManager')->get('EportalProperty\Form\EportalProperty');
            $baseFieldset = $this->propertyForm->getBaseFieldset();
            switch($property){
                case 'class':
                    $baseFieldset->remove('section')
                        ->remove('subject')
                        ->remove('department');
                    break;
                case 'section':
                    $baseFieldset->remove('subject')
                        ->remove('department');
                    break;
                default:
                    $baseFieldset->remove('department');
            }
        }
        return $this->propertyForm;
    }
    
    public function getEportalSessionTermUserService() {
        if (!$this->sessionTermService) {
            $this->sessionTermService = $this->getServiceLocator()->get('EportalUser\Service\EportalSessionTermUser');
        }
        return $this->sessionTermService;
    }

    public function getEportalPropertyUser() {
        if (!$this->eportalPropertyUser) {
            $this->eportalPropertyUser = $this->getServiceLocator()->get('EportalUser\Service\EportalPropertyUser');
        }
        return $this->eportalPropertyUser;
    }

    public function getEportalUserUtil() {
        if (!$this->userUtilService) {
            $this->userUtilService = $this->getServiceLocator()->get('EportalUser\Service\Util');
        }
        return $this->userUtilService;
    }

}
