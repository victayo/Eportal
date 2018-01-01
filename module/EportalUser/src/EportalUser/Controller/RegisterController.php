<?php

namespace EportalUser\Controller;

use EportalUser\Form\EportalRegistrationForm;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * @author OKALA
 */
class RegisterController extends AbstractActionController {

    /**
     *
     * @var EportalRegistrationForm
     */
    protected $form;

    public function indexAction() {
        $role = $this->params()->fromRoute('user', 'student');
        if ($role === 'student') {
            $form = $this->getStudentForm();
        } else {
            $form = $this->getTeacherForm();
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost();
            $user = $post['register']['user'];
            $property = $post['register']['property'];
            $success = $this->saveUser()->save($user, $property, $role);
            return ['form' => $form, 'success' => $success, 'role' => $role];
        }
        return ['form' => $form, 'role' => $role];
    }

    public function getForm() {
        if (!$this->form) {
            $this->form = $this->getServiceLocator()->get('FormElementManager')->get('EportalUser\Form\Register');
        }
        return $this->form;
    }

    public function getStudentForm() {
        $form = $this->getForm();
        $baseFieldset = $form->getBaseFieldset();
        $baseFieldset->get('property')
                ->remove('subject');
        return $form;
    }

    public function getTeacherForm() {
        $form = $this->getForm();
        $baseFieldset = $form->getBaseFieldset();
        $baseFieldset->get('property')
                ->remove('school')
                ->remove('class')
                ->remove('department')
                ->remove('subject');
        return $form;
    }

    public function setForm(EportalRegistrationForm $form) {
        $this->form = $form;
        return $this;
    }

}
