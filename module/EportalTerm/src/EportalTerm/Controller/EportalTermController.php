<?php

namespace EportalTerm\Controller;

use EportalProperty\Controller\AbstractEportalPropertyController;
use EportalTerm\Service\EportalTermServiceInterface;

/**
 * @author OKALA
 */
class EportalTermController extends AbstractEportalPropertyController{
    
    /**
     *
     * @var EportalTermServiceInterface
     */
    protected $eportalTermService;
    
    public function __construct(EportalTermServiceInterface $eportalTermService){
        $this->eportalTermService = $eportalTermService;
    }
    
    protected function getProperty($query) {
        return [
           'terms' => $this->json($this->eportalTermService->getTerm()),
            'success' => true
        ];
    }
    
    public function manageAction() {
        return $this->redirect()->toRoute(self::TERM_ROUTE, ['action' => 'not-found']);
    }
    
    public function getEportalTermService() {
        return $this->eportalTermService;
    }

    public function setEportalTermService(EportalTermServiceInterface $eportalTermService) {
        $this->eportalTermService = $eportalTermService;
        return $this;
    }

    protected function addChildPost($query, $postData) {
        
    }

    protected function getAddBodyVariables($query) {
        
    }

    protected function getAddHeaderVariables($query) {
        
    }

    protected function getBodyPanelVariables($query) {
        
    }

    protected function getPageHeaderVariables($query) {
        
    }

    protected function removeChild($query) {
        
    }

}
