<?php
namespace Property\Factory\Mapper\Hydrator;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Property\Mapper\Hydrator\PropertyValueHydrator;
/**
 *
 * @author imaleo
 *        
 */
class PropertyValueHydratorFactory implements FactoryInterface
{

    /**
     * (non-PHPdoc)
     *
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     *
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new PropertyValueHydrator($serviceLocator->get('Property\Service\Property'));
    }
}
