<?php

namespace EportalProperty\Controller;

use EportalSetting\Service\EportalSettingServiceInterface;
use Property\Service\PropertyServiceInterface;
use Property\Service\PropertyValueServiceInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

/**
 * @author OKALA
 */
class EportalPropertyData extends AbstractActionController{
    
    /**
     *
     * @var EportalSettingServiceInterface
     */
    protected $settingService;
    
    /**
     *
     * @var PropertyValueServiceInterface
     */
    protected $propertyValueService;
    
    /**
     *
     * @var PropertyServiceInterface
     */
    protected $propertyService;
    
    public function initializeAction(){
        $service = $this->getServiceLocator()->get('EportalSetting\Service\EportalSetting');
        $sessionService = $this->getServiceLocator()->get('EportalSession\Service\EportalSession');
        $active_session = $service->getActiveSession();
        $propertyService = $this->Property();
        $pvService = $this->PropertyValue();
        $schools = $pvService->findByProperty($propertyService->findByName('school'), true);
        $sessions = $pvService->findByProperty($propertyService->findByName('session'), true);
        $terms = $sessionService->getTerms($active_session);
        $var = [
            'active_session' => $active_session,
            'active_term' => $service->getActiveTerm(),
            'schools' => $schools,
            'sessions' => $sessions,
            'terms' => $terms->toArray()
        ];
        return new JsonModel($var);
    }
}
