<?php

namespace EportalSetting\Controller\Plugin;

use Eportal\Controller\Plugin\AbstractEportalControllerPlugin;
use EportalSetting\Service\EportalSettingService;
use Exception;

/**
 *
 * @author imaleo
 */
class EportalSettingSaverPlugin extends AbstractEportalControllerPlugin {

    /**
     *
     * @var EportalSettingService
     */
    protected $settingService;

    public function save($settingData) {
        $this->beginTransaction();
        try {
            $settingService = $this->getSettingService();
            $property = $settingData->getProperty();
            $settingService->setActiveTerm($property->getTerm());
            $settingService->setActiveSession($property->getSession());
            $this->commit();
            return true;
        } catch (Exception $ex) {
            $this->rollBack();
            return false;
        }
    }

    protected function getSettingService(){
        if(!$this->settingService){
            $this->settingService = $this->getServiceLocator()->get('EportalSetting\Service\EportalSetting');
        }
        return $this->settingService;
    }
}
