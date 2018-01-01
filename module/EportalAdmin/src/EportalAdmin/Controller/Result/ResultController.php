<?php

namespace EportalAdmin\Controller\Result;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
/**
 *
 * @author imaleo
 */
class ResultController extends AbstractActionController{
    protected $form;
    protected $sessionContainer;
    
    public function indexAction() {
        parent::indexAction();
    }
    
    public function uploadAction(){
        $form = $this->getUploadForm();
        $request = $this->getRequest();
        if($request->isPost()){
            //do post request...xmlHttpRequest
            return new JsonModel(array(
                
            ));
        }
        return array(
            'form' => $form
        );
    }
    
    public function viewAction(){
        
    }
    protected function getViewForm(){
        if(!$this->form){
            $this->form = $this->getServiceLocator()->get('FormElementManager')->get('EportalAdmin\Form\ResultPass');
        }
        return $this->form;
    }
    
    public function getUploadForm(){
        
    }
}
