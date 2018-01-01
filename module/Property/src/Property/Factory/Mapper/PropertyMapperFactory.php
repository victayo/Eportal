<?php
namespace Property\Factory\Mapper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Property\Mapper\PropertyMapper;
use Property\Model\Property;

/**
 *
 * @author imaleo
 *        
 */
class PropertyMapperFactory implements FactoryInterface
{

    /**
     *
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     *
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $mapper = new PropertyMapper();
        $mapper->setDbAdapter($serviceLocator->get('Zend\Db\Adapter\Adapter'))
        ->setHydrator($serviceLocator->get('Property\Hydrator\Property'))
        ->setEntityPrototype(new Property());
        return $mapper;
    }
}
