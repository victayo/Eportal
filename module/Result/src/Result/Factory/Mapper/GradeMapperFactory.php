<?php

namespace Result\Factory\Mapper;

use Result\Mapper\GradeMapper;
use Result\Model\Grade;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 *
 * @author imaleo
 */
class GradeMapperFactory implements FactoryInterface{
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $grade = new GradeMapper();
        $grade->setDbAdapter($serviceLocator->get('Zend\Db\Adapter\Adapter'))
                ->setHydrator(new ClassMethods())
                ->setEntityPrototype(new Grade())
                ->setTableName('grade');
        return $grade;
    }

}
