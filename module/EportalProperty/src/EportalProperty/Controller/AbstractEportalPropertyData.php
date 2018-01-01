<?php

namespace EportalProperty\Controller;

use Property\Service\PropertyServiceInterface;
use Property\Service\PropertyValueServiceInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

/**
 * @author OKALA
 */
abstract class AbstractEportalPropertyData extends AbstractActionController{
    
    /**
     *
     * @var PropertyServiceInterface
     */
    protected $propertyService;
    
    /**
     *
     * @var PropertyValueServiceInterface
     */
    protected $propertyValueService;
    
    public function indexAction() {
        $property = $this->params()->fromRoute('property');
        $id = $this->params()->fromQuery('id');
        if($id){
            $pv = $this->propertyValueService->findById($id);
            $var = [
                'id' => $pv->getId(),
                'value' => $pv->getValue(),
                'property' => $pv->getProperty()
            ];
            return new JsonModel($var);
        }
        $propEntity = $this->getPropertyService()->findByName($property);
        $pvs = $this->getPropertyValueService()->findByProperty($propEntity);
        return new JsonModel($pvs->toArray());
    }
    
    public function getPropertyService() {
        if(!$this->propertyService){
            $this->propertyService = $this->getServiceLocator()->get('Property\Service\Property');
        }
        return $this->propertyService;
    }

    public function getPropertyValueService() {
        if(!$this->propertyValueService){
            $this->propertyValueService = $this->getServiceLocator()->get('Property\Service\PropertyValue');
        }
        return $this->propertyValueService;
    }

    public function setPropertyService(PropertyServiceInterface $propertyService) {
        $this->propertyService = $propertyService;
        return $this;
    }

    public function setPropertyValueService(PropertyValueServiceInterface $propertyValueService) {
        $this->propertyValueService = $propertyValueService;
        return $this;
    }


}
