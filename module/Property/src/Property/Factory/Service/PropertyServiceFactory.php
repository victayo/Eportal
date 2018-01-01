<?php
namespace Property\Factory\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Property\Service\PropertyService;

class PropertyServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new PropertyService($serviceLocator->get('Property\Mapper\Property'));
    }
}