<?php

namespace EportalUser\Controller;

use EportalUser\Form\EportalUserForm;
use EportalUser\Service\EportalUserServiceInterface;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * @author OKALA
 */
class EditController extends AbstractUserController{
    
    /**
     *
     * @var EportalUserForm
     */
    protected $form;

    public function indexAction() {
        $uid = $this->params()->fromQuery('uid', null);
        if(!$uid){
            
        }
        $form = $this->getForm();
        $service = $this->getEportalUserService();
        $user = $service->findById($uid);
        $form->bind($user);
        $request = $this->getRequest();
        if($request->isPost()){
            $data = $request->getPost();
            $form->setData($data);
            if($form->isValid()){
                $user->setId($uid);
                $service->update($user);
//                return $this->redirect()->toRoute('zfcadmin/user');
                return ['form'=>$form, 'valid'=>true];
            }
            return ['form'=>$form, 'valid'=>false];
        }
        return ['form' => $form];
    }
    
    public function getForm() {
        if(!$this->form){
            $this->form = $this->getServiceLocator()->get('FormElementManager')->get('EportalUser\Form\User');
            $this->form->setValidationGroup([
                'user'=>['id', 'first_name', 'middle_name', 'last_name', 'dob', 'gender', 'username']
            ]);
        }
        return $this->form;
    }
    
    public function setForm(EportalUserForm $form) {
        $this->form = $form;
        return $this;
    }


}
