<?php

namespace EportalProperty\Form;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 * @author imaleo
 */
abstract class AbstractEportalPropertyFieldset extends Fieldset implements InputFilterProviderInterface, ServiceLocatorAwareInterface {

    protected $serviceLocator;
    protected $propertyService;
    protected $propertyValueService;
    protected $settingService;

    public function init() {
        $this->add(array(
            'name' => 'id',
            'type' => 'hidden'
        ));
        $this->add(array(
            'name' => 'value',
            'attributes' => array(
                'type' => 'text',
                'required' => 'required'
            ),
        ));
    }

    public function getInputFilterSpecification() {
        return [
            'value' => [
                'required' => true,
                'filters' => [
                    ['name' => 'StringTrim']
                ],
                'validators' => [
                    ['name' => 'NotEmpty']
                ]
            ]
        ];
    }

    public function getServiceLocator() {
        return $this->serviceLocator;
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
        $this->serviceLocator = $serviceLocator;
    }

    public function getPropertyService() {
        if (!$this->propertyService) {
            $realServiceLocator = $this->serviceLocator->getServiceLocator();
            $this->propertyService = $realServiceLocator->get('Property\Service\Property');
        }
        return $this->propertyService;
    }

    public function getPropertyValueService() {
        if (!$this->propertyValueService) {
            $realServiceLocator = $this->serviceLocator->getServiceLocator();
            $this->propertyValueService = $realServiceLocator->get('Property\Service\PropertyValue');
        }
        return $this->propertyValueService;
    }

    public function setPropertyService($propertyService) {
        $this->propertyService = $propertyService;
        return $this;
    }

    public function setPropertyValueService($propertyValueService) {
        $this->propertyValueService = $propertyValueService;
        return $this;
    }

    protected function populateValueOptions($propertyName) {
        $property = $this->getPropertyService()->findByName($propertyName);
        $propertyValues = $this->getPropertyValueService()->findByProperty($property);
        $valueOptions = array();
        foreach ($propertyValues as $propertyValue) {
            $valueOptions[$propertyValue->getId()] = ucwords($propertyValue->getValue());
        }
        return $valueOptions;
    }

    public function getSettingService() {
        if (!$this->settingService) {
            $rl = $this->getServiceLocator()->getServiceLocator();
            $this->settingService = $rl->get('EportalSetting\Service\EportalSetting');
        }
        return $this->settingService;
    }

    public function setSettingService($settingService) {
        $this->settingService = $settingService;
        return $this;
    }

}
