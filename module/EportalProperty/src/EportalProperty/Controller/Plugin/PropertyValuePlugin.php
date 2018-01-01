<?php

namespace EportalProperty\Controller\Plugin;

/**
 * @author OKALA
 */
class PropertyValuePlugin extends \Zend\Mvc\Controller\Plugin\AbstractPlugin{
    
    public function __invoke() {
       $serviceLocator = $this->getController()->getServiceLocator();
       return $serviceLocator->get('Property\Service\PropertyValue');
    }
}
