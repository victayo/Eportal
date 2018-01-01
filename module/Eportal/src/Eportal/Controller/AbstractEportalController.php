<?php

namespace Eportal\Controller;

use Eportal\Service\EportalUtil;
use EportalSetting\Service\EportalSettingService;
use Zend\Mvc\Controller\AbstractActionController;

/**
 *
 * @author imaleo
 */
abstract class AbstractEportalController extends AbstractActionController{
    
    /**
     *
     * @var EportalUtil
     */
    protected $eportalUtilService;
    
    /**
     *
     * @var EportalSettingService
     */
    protected $eportalSettingService;
    
 

    public function getEportalUtilService() {
        if(!$this->eportalUtilService){
            $this->eportalUtilService = $this->getServiceLocator()->get('Eportal\Service\Util');
        }
        return $this->eportalUtilService;
    }

    public function setEportalUtilService(EportalUtil $eportalUtilService) {
        $this->eportalUtilService = $eportalUtilService;
        return $this;
    }
    
    public function getEportalSettingService() {
        if (!$this->eportalSettingService){
            $this->eportalSettingService = $this->getServiceLocator()->get('EportalSetting\Service\EportalSetting');
    }
        return $this->eportalSettingService;
    }

    public function setEportalSettingService(EportalSettingService $eportalSettingService) {
        $this->eportalSettingService = $eportalSettingService;
        return $this;
    }
    
}
