<?php

namespace EportalSession\Controller;

use EportalProperty\Controller\AbstractEportalPropertyData;
use EportalSession\Service\EportalSessionServiceInterface;
use EportalUser\Service\UserSessionTermServiceInterface;
use Zend\View\Model\JsonModel;

/**
 * @author OKALA
 */
class EportalSessionData extends AbstractEportalPropertyData{
    
    /**
     *
     * @var EportalSessionServiceInterface
     */
    protected $eportalSessionService;
    
    /**
     *
     * @var UserSessionTermServiceInterface
     */
    protected $eportalSessionUserService;
    
    public function getTermAction(){
        $query = $this->params()->fromQuery();
        $terms = isset($query['unregistered'])
                ? $this->getEportalSessionService()->getUnmappedTerms($query['session'])
                : $this->getEportalSessionService()->getTerms($query['session']);
        return new JsonModel($terms->toArray());
    }
    
    public function getEportalSessionService() {
        if(!$this->eportalSessionService){
            $this->eportalSessionService = $this->getServiceLocator()->get('EportalSession\Service\EportalSession');
        }
        return $this->eportalSessionService;
    }

    public function getEportalSessionUserService() {
        if(!$this->eportalSessionUserService){
            $this->eportalSessionUserService = $this->getServiceLocator()->get('EportalUser\Service\UserSessionTerm');
        }
        return $this->eportalSessionUserService;
    }

    public function setEportalSessionService(EportalSessionServiceInterface $eportalSessionService) {
        $this->eportalSessionService = $eportalSessionService;
        return $this;
    }

    public function setEportalSessionUserService(EportalSessionUserService $eportalSessionUserService) {
        $this->eportalSessionUserService = $eportalSessionUserService;
        return $this;
    }


}
