<?php

namespace Eportal\Controller;

use EportalProperty\Form\EportalPropertyForm;
use EportalProperty\Service\EportalPropertyUserService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

/**
 * @author OKALA
 */
class StudentController extends AbstractActionController {

    const ROUTE_LOGIN = 'zfcuser/login';

    /**
     *
     * @var EportalPropertyUserService
     */
    protected $eportalPropertyUserService;

    /**
     *
     * @var EportalPropertyForm
     */
    protected $resultForm;

    public function __construct(EportalPropertyUserService $eportalPropertyUserService) {
        $this->eportalPropertyUserService = $eportalPropertyUserService;
    }

    public function indexAction() {
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute(static::ROUTE_LOGIN, [], ['query' => ['redirect' => 'student']]);
        }
        $user = $this->zfcUserAuthentication()->getIdentity();
        $container = new Container('eportal_login');
        $userId = $user->getId();
        $session = $container->session;
        $term = $container->term;
        $school = $this->eportalPropertyUserService->getSchool($userId, $session, $term)->current();
        $class = $this->eportalPropertyUserService->getClass($userId, $session, $term)->current();
        $department = $this->eportalPropertyUserService->getDepartment($userId, $session, $term)->current();
        $subjects = $this->eportalPropertyUserService->getSubject($userId, $session, $term);
        $propertyValue = $this->PropertyValue();
        return [
            'school' => $school,
            'class' => $class,
            'department' => $department,
            'subjects' => $subjects,
            'user' => $user,
            'session' => $propertyValue->findById($session),
            'term' => $propertyValue->findById($term)
        ];
    }

    public function resultAction() {
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute(static::ROUTE_LOGIN, [], ['query' => ['redirect' => 'student/result']]);
        }
        $container = new Container('eportal_student');
        $json = $this->params()->fromQuery('json');
        $student = $this->zfcUserAuthentication()->getIdentity()->getId();
        if ($json) {
            $model = new JsonModel();
            $session = $container->session;
            $term = $container->term;
            $resultData = $this->Result()->getViewData($student, $session, $term);
            $propertyValue = $this->PropertyValue();
            $model->setVariables([
                'result_data' => $resultData,
                'session' => $propertyValue->findById($session, true),
                'term' => $propertyValue->findById($term, true)
            ]);
            return $model;
        }
        $form = $this->getResultForm();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $property = $form->getData();
                $container->session = $property->getSession();
                $container->term = $property->getTerm();
                $model = new ViewModel();
                $model->setTemplate('eportal\student\result_view.phtml');
                return $model;
            }
        }
        return ['form' => $form];
    }

    public function getResultForm() {
        if (!$this->resultForm) {
            $this->resultForm = $this->getServiceLocator()->get('FormElementManager')->get('EportalProperty\Form\EportalProperty');
            $fieldset = $this->resultForm->getBaseFieldset();
            $fieldset->remove('school')
                    ->remove('class')
                    ->remove('subject')
                    ->remove('department');
        }
        return $this->resultForm;
    }

    public function getEportalPropertyUserService() {
        return $this->eportalPropertyUserService;
    }
    
    public function setEportalPropertyUserService(EportalPropertyUserService $eportalPropertyUserService) {
        $this->eportalPropertyUserService = $eportalPropertyUserService;
        return $this;
    }

}
