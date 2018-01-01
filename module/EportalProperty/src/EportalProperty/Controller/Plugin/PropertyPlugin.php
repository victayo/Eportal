<?php

namespace EportalProperty\Controller\Plugin;

/**
 * @author OKALA
 */
class PropertyPlugin extends \Eportal\Controller\Plugin\AbstractEportalControllerPlugin{
    
    public function __invoke() {
        $serviceLocator = $this->getController()->getServiceLocator();
        return $serviceLocator->get('Property\Service\Property');
    }
}
