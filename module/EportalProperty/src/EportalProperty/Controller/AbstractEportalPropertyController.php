<?php

namespace EportalProperty\Controller;

use Property\Form\PropertyValueForm;
use Property\Service\PropertyServiceInterface;
use Property\Service\PropertyValueServiceInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

/**
 * @author OKALA
 */
abstract class AbstractEportalPropertyController extends AbstractActionController {

    const SCHOOL_ROUTE = 'zfcadmin/eportal-school';
    const CLASS_ROUTE = 'zfcadmin/eportal-class';
    const DEPARTMENT_ROUTE = 'zfcadmin/eportal-department';
    const SUBJECT_ROUTE = 'zfcadmin/eportal-subject';
    const SESSION_ROUTE = 'zfcadmin/eportal-session';
    const TERM_ROUTE = 'zfcadmin/eportal-term';
    const EPORTAL_SCHOOL = 'school';
    const EPORTAL_CLASS = 'class';
    const EPORTAL_DEPARTMENT = 'department';
    const EPORTAL_SUBJECT = 'subject';
    const EPORTAL_SESSION = 'session';
    const EPORTAL_TERM = 'term';

    /**
     *
     * @var PropertyValueForm
     */
    protected $form;

    /**
     *
     * @var PropertyValueServiceInterface
     */
    private $propertyValueService;

    /**
     *
     * @var PropertyServiceInterface
     */
    private $propertyService;

    public function indexAction() {
        $query = $this->params()->fromQuery();
        if (isset($query['json'])) {
            return new JsonModel($this->getProperty($query));
        }
        $property = $this->params()->fromRoute('property');
        $mainModel = new ViewModel();
        $propertyEntity = $this->Property()->findByName($property);
        $propertyValues = $this->PropertyValue()->findByProperty($propertyEntity);
        $mainModel->setTemplate('eportal-property/index')
                ->setVariables(['property_values' => $propertyValues, 'property' => $property]);
        return $mainModel;
    }

    public function manageAction() {
        $property = $this->params()->fromRoute('property');
        $query = $this->params()->fromQuery();
        $mainModel = new ViewModel();
        if (isset($query['json'])) {
            return new JsonModel($this->getProperty($query));
        }
        if ($query) {
            $pageHeaderModel = new ViewModel($this->getPageHeaderVariables($query));
            $pageHeaderModel->setTemplate('eportal-property/manage/page-header');
            $bodyModel = new ViewModel($this->getBodyPanelVariables($query));
            $bodyModel->setTemplate('eportal-property/manage/body');
            $mainModel->addChild($pageHeaderModel, 'page_header')
                    ->addChild($bodyModel, 'body')
                    ->setTemplate('eportal-property/manage/manage-child');
            return $mainModel;
        }
        $propertyEntity = $this->Property()->findByName($property);
        $propertyValues = $this->PropertyValue()->findByProperty($propertyEntity);
        $mainModel->setTemplate('eportal-property/manage/manage')
                ->setVariables(['property_values' => $propertyValues, 'property' => $property]);
        return $mainModel;
    }

    public function saveAction() {
        $id = $this->params()->fromQuery('pid', null);
        $property = $this->params()->fromRoute('property');
        $form = $this->getForm();
        $propertyEntity = $this->Property()->findByName($property);
        if ($id) {//edit
            $propertyValue = $this->PropertyValue()->findById($id);
            $action = 'edit';
        } else {//add
            $propertyValue = $this->PropertyValue()->getEntity(null, null, $propertyEntity);
            $action = 'add';
        }
        $form->bind($propertyValue);
        $model = new ViewModel();
        $model->setTemplate('eportal-property/save/add-edit');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost();
            $form->setData($data);
            if ($form->isValid()) {
                $this->PropertyValue()->save($form->getData());
                return $this->redirect()->toRoute();
            } else {
                $var = ['form' => $form, 'property' => $property, 'action' => $action, 'success' => false];
                $model->setVariables($var);
                return $model;
            }
        }
        $var = ['form' => $form, 'property' => $property, 'action' => $action];
        $model->setVariables($var, TRUE);
        return $model;
    }

    public function addChildAction() {
        $query = $this->params()->fromQuery();
        $request = $this->getRequest();
        if ($request->isPost()) {
            return $this->addChildPost($query, $request->getPost()['child']);
        }
        $model = new ViewModel();
        $headerModel = new ViewModel($this->getAddHeaderVariables($query));
        $headerModel->setTemplate('eportal-property/save/add-header');
        $bodyModel = new ViewModel($this->getAddBodyVariables($query));
        $bodyModel->setTemplate('eportal-property/save/add-body');
        $model->addChild($headerModel, 'page_header')
                ->addChild($bodyModel, 'body')
                ->setTemplate('eportal-property/save/add-child');
        return $model;
    }

    public function deleteChildAction() {
        $query = $this->params()->fromQuery();
        return $this->removeChild($query);
    }

    public function deleteAction() {
        $query = $this->params()->fromQuery();
        if (!isset($query['pid'])) {
            return $this->notFoundAction();
        }
        if (count($query) > 1) {
            return $this->removeChild($query);
        }
        $id = $query['pid'];
        $request = $this->getRequest();
        $propertyValueService = $this->PropertyValue();
        $propertyValue = $propertyValueService->findById($id);
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');
            if ($del == 'Yes') {
                $propertyValueService->delete($propertyValue);
                return $this->redirect()->toRoute();
            }
        }
        $model = new ViewModel(['property_value' => $propertyValue]);
        $model->setTemplate('eportal-property/delete');
        return $model;
    }

    public function getForm() {
        if (!$this->form) {
            $this->form = $this->getServiceLocator()->get('FormElementManager')->get('Property\Form\PropertyValue');
        }
        return $this->form;
    }

    public function setForm(PropertyValueForm $form) {
        $this->form = $form;
        return $this;
    }

    protected function getPropertyValueService() {
        if (!$this->propertyValueService) {
            $this->propertyValueService = $this->getServiceLocator()->get('Property\Service\PropertyValue');
        }
        return $this->propertyValueService;
    }

    protected function getPropertyService() {
        if (!$this->propertyService) {
            $this->propertyService = $this->getServiceLocator()->get('Property\Service\Property');
        }
        return $this->propertyService;
    }

    protected function json($propertyValues) {
        $return = [];
        foreach ($propertyValues as $propertyValue) {
            $return [] = [
                'id' => $propertyValue->getId(),
                'value' => $propertyValue->getValue()
            ];
        }
        return $return;
    }

//    abstract protected function addActionSave($propertyValue);

    abstract protected function getProperty($query);

    abstract protected function removeChild($query);

    abstract protected function addChildPost($query, $postData);

    abstract protected function getBodyPanelVariables($query);

    abstract protected function getPageHeaderVariables($query);

    abstract protected function getAddHeaderVariables($query);

    abstract protected function getAddBodyVariables($query);
}
