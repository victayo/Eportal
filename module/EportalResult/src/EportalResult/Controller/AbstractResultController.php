<?php

namespace EportalResult\Controller;

use EportalProperty\Service\EportalPropertyValueService;
use EportalProperty\Service\EportalRelPropertyValueService;
use EportalSetting\Service\EportalSettingService;
use EportalUser\Service\RelUserPropertyValueService;
use EportalUser\Service\UserPropertyValueService;
use Result\Service\AssessmentServiceInterface;
use Result\Service\ResultServiceInterface;
use Zend\Mvc\Controller\AbstractActionController;

/**
 *
 * @author imaleo
 */
abstract class AbstractResultController extends AbstractActionController{
    
    /**
     *
     * @var EportalSettingService
     */
    protected $settingService;
    
    /**
     *
     * @var EportalRelPropertyValueService
     */
    protected $eportalRelPropertyValueService;
    
    /**
     *
     * @var EportalPropertyValueService
     */
    protected $eportalPropertyValueService;
    
    /**
     *
     * @var UserPropertyValueService
     */
    protected $userPropertyValueService;
    
    /**
     *
     * @var RelUserPropertyValueService
     */
    protected $relUserPropertyValueService;
    
    
    /**
     *
     * @var AssessmentServiceInterface
     */
    protected $assessmentService;
    
    /**
     *
     * @var ResultServiceInterface
     */
    protected $resultService;
    
    public abstract function processAction();
    
    public function getSettingService() {
        if(!$this->settingService){
            $this->settingService = $this->getServiceLocator()->get('EportalSetting\Service\EportalSetting');
        }
        return $this->settingService;
    }

    public function setSettingService(EportalSettingService $settingService) {
        $this->settingService = $settingService;
        return $this;
    }

    public function getEportalRelPropertyValueService() {
        if(!$this->eportalRelPropertyValueService){
            $this->eportalRelPropertyValueService = $this->getServiceLocator()->get('EportalProperty\Service\EportalRelPropertyValue');
        }
        return $this->eportalRelPropertyValueService;
    }

    public function setEportalRelPropertyValueService(EportalRelPropertyValueService $eportalJointPropertyValueService) {
        $this->eportalRelPropertyValueService = $eportalJointPropertyValueService;
        return $this;
    }

    public function getEportalPropertyValueService() {
        if(!$this->eportalPropertyValueService){
            $this->eportalPropertyValueService = $this->getServiceLocator()->get('EportalProperty\Service\EportalPropertyValue');
        }
        return $this->eportalPropertyValueService;
    }

    public function setEportalPropertyValueService(EportalPropertyValueService $eportalPropertyValue) {
        $this->eportalPropertyValueService = $eportalPropertyValue;
        return $this;
    }

    public function getUserPropertyValueService() {
        if(!$this->userPropertyValueService){
            $this->userPropertyValueService = $this->getServiceLocator()->get('EportalUser\Service\UserPropertyValue'); 
       }
        return $this->userPropertyValueService;
    }

    public function setUserPropertyValueService(UserPropertyValueService $userPropertyValueService) {
        $this->userPropertyValueService = $userPropertyValueService;
        return $this;
    }

    public function getRelUserPropertyValueService(){
        if(!$this->relUserPropertyValueService){
            $this->relUserPropertyValueService = $this->getServiceLocator()->get('EportalUser\Service\RelUserPropertyValue');
        }
        return $this->relUserPropertyValueService;
    }
    
    public function setRelUserPropertyValueService(RelUserPropertyValueService $rupv){
        $this->relUserPropertyValueService = $rupv;
        return $this;
    }
    
    public function getAssessmentService() {
        if(!$this->assessmentService){
            $this->assessmentService = $this->getServiceLocator()->get('Result\Service\Assessment');
        }
        return $this->assessmentService;
    }

    public function getResultService() {
        if(!$this->resultService){
            $this->resultService = $this->getServiceLocator()->get('Result\Service\Result');
        }
        return $this->resultService;
    }

    public function setAssessmentService(AssessmentServiceInterface $assessmentService) {
        $this->assessmentService = $assessmentService;
        return $this;
    }

    public function setResultService(ResultServiceInterface $resultService) {
        $this->resultService = $resultService;
        return $this;
    }


}
