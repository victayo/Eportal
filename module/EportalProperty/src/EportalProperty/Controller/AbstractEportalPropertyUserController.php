<?php

namespace EportalProperty\Controller;

use EportalProperty\Form\EportalPropertyForm;
use Property\Service\PropertyValueServiceInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

/**
 * @author OKALA
 */
abstract class AbstractEportalPropertyUserController extends AbstractActionController{
    /**
     *
     * @var PropertyValueServiceInterface
     */
    protected $propertyValueService;
    
    /**
     *
     * @var Container
     */
    protected $sessionContainer;
    
    /**
     *
     * @var EportalPropertyForm
     */
    protected $propertyForm;
    
    public function indexAction() {
        $role = $this->params()->fromRoute('user');
        if($this->sessionContainer->initialized){
            $property = $this->sessionContainer->property;
            return $this->getUsers($property, $role);
        }
        $model = new ViewModel();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost();
            $property = $post['eportal_property'];
            $this->sessionContainer->property = $property;
            $model->setTemplate('eportal-property-user/index')
                    ->setVariables($this->getUsers($property, $role));
            return $model;
        }
        $form = $this->getPropertyForm();
        $model->setTemplate('eportal-property-user/index_form')
                ->setVariables(['form' => $form, 'role' => $role]);
        return $model;
    }
    
    public function getPropertyValueService() {
        if (!$this->propertyValueService) {
            $this->propertyValueService = $this->getServiceLocator()->get('Property\Service\PropertyValue');
        }
        return $this->propertyValueService;
    }

    public function setPropertyValueService(PropertyValueServiceInterface $propertyValueService) {
        $this->propertyValueService = $propertyValueService;
        return $this;
    }
    
    public function getPropertyForm() {
        if (!$this->propertyForm) {
            $this->propertyForm = $this->getServiceLocator()->get('FormElementManager')->get('EportalProperty\Form\EportalProperty');
        }
        return $this->propertyForm;
    }
    
    abstract protected function getUsers($property, $role);
}
