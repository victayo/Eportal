<?php

namespace Result\Factory\Mapper;

use Result\Mapper\ResultMapper;
use Result\Model\Result;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 *
 * @author imaleo
 */
class ResultMapperFactory implements FactoryInterface{
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $result = new ResultMapper();
        $result->setDbAdapter($serviceLocator->get('Zend\Db\Adapter\Adapter'))
                ->setHydrator(new ClassMethods())
                ->setEntityPrototype(new Result());
        return $result;
    }

}
