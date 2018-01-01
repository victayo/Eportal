<?php

namespace EportalUser\Controller\Student;

use EportalProperty\Model\EportalProperty;
use EportalUser\Controller\AbstractUserController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
/**
 *
 * @author imaleo
 */
class RegisterController extends AbstractUserController {

    const SINGLE_REG_TYPE = 'single';
    const MULTIPLE_REG_TYPE = 'multiple';

    protected $form;

    public function registerAction() {
//        $regType = $this->params()->fromQuery('type', self::SINGLE_REG_TYPE);
        $form = $this->getForm();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost();
            $form->setData($post);
            if($form->isValid()){
                $user = $post['user'];
                $property = $post['property'];
                
                $this->save($user, $property);
            }
        }
        $model = new ViewModel(array('form' => $form, 'type' => $regType));
        $model->setTemplate('eportal-user\register\\' . $regType);
        return $model;
    }
    
    protected function save($user, $property){
        $user['password'] = $user['passwordVerify'] = $user['first_name'];
        $user = $this->getuserService()->register($user);
        //....
    }
    protected function processRegister($regType = self::SINGLE_REG_TYPE) {
        $request = $this->getRequest();
//        $model = new ViewModel();
        $model = new JsonModel();
        $post = $request->getPost();
        $form = $this->getForm($regType);
        if ($regType == self::MULTIPLE_REG_TYPE) {
            $data = array_merge_recursive($post->toArray(), $request->getFiles()->toArray());
        } else {
            $data = json_decode($request->getContent(), TRUE);
            $form = $this->getValidationGroup($form, $data['register']['property']);
        }
        $form->setData($data);
//        $model->setTemplate('eportal-user\student\register\\' . $regType);
        if ($form->isValid()) {
            if ($regType == self::SINGLE_REG_TYPE) {
                $valid = $this->processSingleRegister($data);
            } else {
                $valid = $this->processMultipleRegister();
            }
            $model->setVariables(array(
//                'form' => $form,
                'success' => true,
                'valid' => $valid
            ));
            return $model;
        }
        $model->setVariables(array(
            'success' => true,
            'valid' => false,
//            'form' => $form
        ));
        return $model;
    }

    protected function processSingleRegister() {
        $form = $this->getForm();
        $register = $form->getData();
        $property = $register->getProperty();
        return $this->saveUser()->saveStudent($register->getUser(), $property);
    }

    protected function processMultipleRegister() {
        $form = $this->getForm(self::MULTIPLE_REG_TYPE);
        $formData = $form->getData();
        $users = $formData->getUsers();
        $property = new EportalProperty();
        $property->setSession($formData->getSession());
        $property->setTerm($formData->getTerm());
        return $this->saveMultipleUsers()->save($users, $property);
    }

    protected function getForm($type = self::SINGLE_REG_TYPE) {

        if (!$this->form) {
            if ($type == self::SINGLE_REG_TYPE) {
                $this->form = $this->getServiceLocator()->get('FormElementManager')->get('EportalUser\Form\Register');
            } else {
                $this->form = $this->getServiceLocator()->get('FormElementManager')->get('EportalUser\Form\UserUpload');
            }
        }
        return $this->form;
    }

    protected function getValidationGroup($form, $property){
        $validationGroup = $form->getValidationGroup();
        if($property['department']){
            $validationGroup['register']['property'][] = 'department';
        }
        if($property['section']){
            $validationGroup['register']['property'][] = 'section';
        }
        $form->setValidationGroup($validationGroup);
        return $form;
    }
}
