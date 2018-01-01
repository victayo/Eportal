<?php

namespace EportalUser\Controller;

use Eportal\Controller\AbstractEportalController;
use EportalUser\Service\EportalUserServiceInterface;
use EportalUser\Service\RelUserPropertyValueService;
use EportalUser\Service\UserSessionTermServiceInterface;

/**
 *
 * @author imaleo
 */
abstract class AbstractUserController extends AbstractEportalController {

    const SINGLE_REG_TYPE = 'single';
    const MULTIPLE_REG_TYPE = 'multiple';

    /**
     *
     * @var UserSessionTermServiceInterface
     */
    protected $ujpv;

    /**
     *
     * @var EportalUserServiceInterface
     */
    protected $userService;

    /*
     *
     * @var RelUserPropertyValueService
     */
    protected $relUserpvService;

    protected $settingService;
    
    public function getSettingService() {
        if (!$this->settingService) {
            $this->settingService = $this->getServiceLocator()->get('EportalSetting\Service\EportalSetting');
        }
        return $this->settingService;
    }


    public function getUserSessionTermService() {
        if (!$this->ujpv) {
            $this->ujpv = $this->getServiceLocator()->get('EportalUser\Service\UserSessionTerm');
        }
        return $this->ujpv;
    }

    public function getEportalUserService() {
        if (!$this->userService) {
            $this->userService = $this->getServiceLocator()->get('EportalUser\Service\EportalUser');
        }
        return $this->userService;
    }

    public function setUserSessionTermService(UserSessionTermServiceInterface $service) {
        $this->ujpv = $service;
        return $this;
    }

    public function setEportalUserService(EportalUserServiceInterface $service) {
        $this->userService = $service;
        return $this;
    }

    public function getRelUserPropertyValueService(){
        if(!$this->relUserpvService){
            $this->relUserpvService = $this->getServiceLocator()->get('EportalUser\Service\RelUserPropertyValue');
        }
        return $this->relUserpvService;
    }
    
    public function setRelUserPropertyValueService(RelUserPropertyValueService $rupvService){
        $this->relUserpvService = $rupvService;
        return $this;
    }
}
