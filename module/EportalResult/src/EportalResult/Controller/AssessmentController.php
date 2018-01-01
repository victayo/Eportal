<?php

namespace EportalResult\Controller;

use EportalResult\Form\AssessmentForm;
use Result\Service\AssessmentServiceInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

/**
 * @author OKALA
 */
class AssessmentController extends AbstractActionController {

    /**
     *
     * @var AssessmentServiceInterface
     */
    protected $assessmentService;

    /**
     *
     * @var AssessmentForm
     */
    protected $assessmentForm;
    
    public function __construct(AssessmentServiceInterface $assessmentService) {
        $this->assessmentService = $assessmentService;
    }

    public function indexAction() {
        $json = $this->params()->fromQuery('json');
        $assessments = $this->assessmentService->getAll()->toArray();
        $var = ['assessments' => $assessments];
        if($json){
            return new JsonModel($var);
        }
        return $var;
    }
    
    public function addAction(){
        $form = $this->getAssessmentForm();
        $request = $this->getRequest();
        if($request->isPost()){
            $data = $request->getPost();
            $form->setData($data);
            if($form->isValid()){
                $this->assessmentService->insert($form->getData());
                return $this->redirect()->toRoute();
            }
        }
        return ['form' => $form];
    }
    
    public function editAction(){
        $id = $this->params()->fromRoute('id', NULL);
        if(!$id){
            return $this->redirect()->toRoute('zfcadmin/result/assessment', ['action' => 'notFound']);
        }
        $assessment = $this->assessmentService->findById($id);
        $form = $this->getAssessmentForm();
        $form->bind($assessment);
        $request = $this->getRequest();
        if($request->isPost()){
            $data = $request->getPost();
            $form->setData($data);
            if($form->isValid()){
                $this->assessmentService->update($assessment);
                return $this->redirect()->toRoute();
            }
        }
        $model = new ViewModel(['form' => $form]);
        $model->setTemplate('eportal-result\assessment\add.phtml');
        return $model;
    }
    
    public function deleteAction(){
        
    }
    
    public function getAssessmentForm(){
        if(!$this->assessmentForm){
            $this->assessmentForm = $this->getServiceLocator()->get('FormElementManager')->get('EportalResult\Form\Assessment');
        }
        return $this->assessmentForm;
    }

}
