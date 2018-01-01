<?php
namespace Property\Factory\Mapper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Property\Mapper\PropertyValueMapper;
use Property\Model\PropertyValue;
/**
 *
 * @author imaleo
 *        
 */
class PropertyValueMapperFactory implements FactoryInterface
{

    /**
     * (non-PHPdoc)
     *
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     *
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $mapper = new PropertyValueMapper();
        $mapper->setDbAdapter($serviceLocator->get('Zend\Db\Adapter\Adapter'))
        ->setHydrator($serviceLocator->get('Property\Hydrator\PropertyValue'))
        ->setEntityPrototype(new PropertyValue());
        return $mapper;
    }
}

?>