<?php

namespace Result\Factory\Mapper;

use Result\Mapper\ResultScoreMapper;
use Result\Model\ResultScore;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 *
 * @author imaleo
 */
class ResultScoreMapperFactory implements FactoryInterface{
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $result = new ResultScoreMapper();
        $result->setDbAdapter($serviceLocator->get('Zend\Db\Adapter\Adapter'))
                ->setHydrator(new ClassMethods())
                ->setEntityPrototype(new ResultScore());
        return $result;
    }

}
