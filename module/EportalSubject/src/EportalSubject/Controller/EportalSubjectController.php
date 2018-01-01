<?php

namespace EportalSubject\Controller;

use EportalProperty\Controller\AbstractEportalPropertyController;
use EportalSubject\Service\EportalSubjectServiceInterface;

/**
 * @author OKALA
 */
class EportalSubjectController extends AbstractEportalPropertyController{
    
    /**
     *
     * @var EportalSubjectServiceInterface
     */
    protected $eportalSubjectService;
    
    public function __construct(EportalSubjectServiceInterface $eportalSubjectService) {
        $this->eportalSubjectService = $eportalSubjectService;
    }
    
    public function manageAction() {
        return $this->notFoundAction();
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

    protected function getProperty($query) {
        return [
           'subjects' => $this->json($this->eportalSubjectService->getSubject()),
            'success' => true
        ];
    }

    protected function removeChild($query) {
        
    }

}
