<?php

namespace EportalSetting\Controller;

use Eportal\Service\EportalUtil;
use EportalProperty\Service\EportalSessionService;
use EportalProperty\Service\EportalTermService;
use EportalSetting\Form\EportalSettingForm;
use EportalSetting\Service\EportalSettingService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

/**
 *
 * @author imaleo
 */
class EportalSettingController extends AbstractActionController{
    /**
     *
     * @var EportalSettingForm
     */
    protected $form;
    
    /**
     *
     * @var EportalSettingService
     */
    protected $settingService;
    /**
     *
     * @var EportalSessionService
     */
    protected $sessionService;
    
    /**
     *
     * @var EportalTermService
     */
    protected $termService;
    
    /**
     *
     * @var EportalUtil
     */
    protected $utilService;
    public function indexAction() {
        $form = $this->getSettingForm();
        $request = $this->getRequest();
        if($request->isPost()){
            $data = $request->getPost();
            $form->setData($data);
            if($form->isValid()){
                $success = $this->saveSetting()->save($form->getData());
            }else{
                $success = false;
            }
             return ['form' => $form, 'success' => $success];
        }
        return ['form' => $form];
    }
    
    public function getActiveAction(){
        $session = $this->getSettingService()->getActiveSession();
        $term = $this->getSettingService()->getActiveTerm();
        return new JsonModel([
            'active_session' => $session,
            'active_term' => $term,
            'success' => true
        ]);
    }

    public function getSettingForm() {
        if(!$this->form){
            $this->form = $this->getServiceLocator()->get('FormElementManager')->get('EportalSetting\Form\EportalSetting');
            $fieldset = $this->form->getBaseFieldset()->get('property');
            $fieldset->remove('school')
                    ->remove('class')
                    ->remove('department')
                    ->remove('subject');
            $fieldset->get('session')
                    ->setLabel('Active Session');
            $fieldset->get('term')
                    ->setLabel('Active Term');
        }
        return $this->form;
    }

    public function setSettingForm(EportalSettingForm $form) {
        $this->form = $form;
        return $this;
    }

    private function populate($fieldset){
        $select = $fieldset->get('activeSession');
        $term = $fieldset->get('activeTerm');
        $sessions = $this->getSessionService()->getSession();
        $terms = $this->getTermService()->getTerm();
        $vo = $this->getUtilService()->propertyValueToFormOptions($sessions);
        $select->setValueOptions($vo);
        $vo = $this->getUtilService()->propertyValueToFormOptions($terms);
        $term->setValueOptions($vo);
        
    }

    private function bind($form){
        
    }
    
    public function getSessionService() {
        if(!$this->sessionService){
            $this->sessionService = $this->getServiceLocator()->get('EportalSession\Service\EportalSession');
        }
        return $this->sessionService;
    }

    public function getTermService() {
        if(!$this->termService){
            $this->termService = $this->getServiceLocator()->get('EportalTerm\Service\EportalTerm');
        }
        return $this->termService;
    }

    protected function getSettingService(){
        if(!$this->settingService){
            $this->settingService = $this->getServiceLocator()->get('EportalSetting\Service\EportalSetting');
        }
        return $this->settingService;
    }
    
    public function getUtilService() {
        if(!$this->utilService){
            $this->utilService = $this->getServiceLocator()->get('Eportal\Service\Util');
        }
        return $this->utilService;
    }

    public function setSessionService(EportalSessionService $sessionService) {
        $this->sessionService = $sessionService;
        return $this;
    }

    public function setTermService(EportalTermService $termService) {
        $this->termService = $termService;
        return $this;
    }

    public function setUtilService(EportalUtil $utilService) {
        $this->utilService = $utilService;
        return $this;
    }


}
