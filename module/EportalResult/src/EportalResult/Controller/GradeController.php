<?php

namespace EportalResult\Controller;

use EportalResult\Form\GradeForm;
use Result\Service\GradeServiceInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * @author OKALA
 */
class GradeController extends AbstractActionController {

    /**
     *
     * @var GradeServiceInterface
     */
    protected $gradeService;

    /**
     *
     * @var GradeForm
     */
    protected $gradeForm;
    
    public function __construct(GradeServiceInterface $gradeService) {
        $this->gradeService = $gradeService;
    }

    public function indexAction() {
        $grades = $this->gradeService->getAll();
        return ['grades' => $grades];
    }

    public function addAction(){
        $form = $this->getGradeForm();
        $request = $this->getRequest();
        if($request->isPost()){
            $form->setData($request->getPost());
            if($form->isValid()){
                $this->gradeService->insert($form->getData());
                return $this->redirect()->toRoute();
            }
        }
        return ['form' => $form];
    }
    
    public function editAction(){
        $id = $this->params()->fromRoute('id', NULL);
        if(!$id){
            return $this->redirect()->toRoute('zfcadmin/result/grade', ['action'=>'notFound']);
        }
        $grade = $this->gradeService->findById($id);
        $form = $this->getGradeForm();
        $form->bind($grade);
        $request = $this->getRequest();
        if($request->isPost()){
            $form->setData($request->getPost());
            if($form->isValid()){
                $this->gradeService->update($form->getData());
                return $this->redirect()->toRoute();
            }
        }
        $model = new ViewModel(['form' => $form]);
        $model->setTemplate('eportal-result\grade\add.phtml');
        return $model;
    }
    
    public function getGradeForm(){
        if(!$this->gradeForm){
            $this->gradeForm = $this->getServiceLocator()->get('FormElementManager')->get('EportalResult\Form\Grade');
        }
       return $this->gradeForm;
    }
}
