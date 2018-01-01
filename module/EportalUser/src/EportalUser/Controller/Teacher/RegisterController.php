<?php

namespace EportalUser\Controller\Teacher;

use EportalUser\Controller\AbstractUserController;
use EportalUser\Form\UserRegistrationForm;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

/**
 *
 * @author imaleo
 */
class RegisterController extends AbstractUserController {

    /**
     *
     * @var UserRegistrationForm
     */
    protected $registerForm;

    public function registerAction() {
        $regType = 'single';
        $form = $this->getRegistrationForm();
        $request = $this->getRequest();
        $model = new ViewModel(array('form' => $form, 'type' => $regType));
        $model->setTemplate('eportal-user\register\\' . $regType);
        if ($request->isPost()) {
            $data = json_decode($request->getContent(), TRUE);
            $form->setData($data);
            if ($form->isValid()) {
                $formData = $form->getData();
                $user = $formData->getUser();
                $property = $formData->getProperty();
                $valid = $this->saveUser()->saveStaff($user, $property);
                return new JsonModel(['valid' => $valid, 'success' => true]);
            }
            return['valid' => false, 'success' => true];
        }
        return $model;
    }

//    public function propertyDataAction() {
//        $data = $this->propertyData()->getClassData();
//        return new JsonModel($data);
//    }

//    protected function validate($data) {
//        $form = $this->getRegistrationForm();
//        $form->setData($data);
//        if ($form->isValid()) {
//            $formData = $form->getData();
//            $user = $formData->getUser();
//            $property = $formData->getProperty();
//            $valid = $this->saveUser()->saveStaff($user, $property);
//            return $valid;
//        }
//        return false;
//    }

    protected function getRegistrationForm() {
        if (!$this->registerForm) {
            $this->registerForm = $this->getServiceLocator()->get('FormElementManager')->get('EportalUser\Form\Register');
            $propertyFieldset = $this->registerForm->getBaseFieldset()->get('property');
            $propertyFieldset->remove('school')
                    ->remove('class')
                    ->remove('department');
            if ($propertyFieldset->has('section')) {
                $this->registerForm->remove('section');
            }
            $validationGroup = $this->registerForm->getValidationGroup();
            $validationGroup['register']['property'] = ['session', 'term'];
            $this->registerForm->setValidationGroup($validationGroup);
        }
        return $this->registerForm;
    }

}
