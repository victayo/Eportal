<?php

namespace Result\Factory\Mapper;

use Result\Mapper\AssessmentMapper;
use Result\Model\Assessment;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 *
 * @author imaleo
 */
class AssessmentMapperFactory implements FactoryInterface{
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $assessment = new AssessmentMapper();
        $assessment->setDbAdapter($serviceLocator->get('Zend\Db\Adapter\Adapter'))
                ->setHydrator(new ClassMethods())
                ->setEntityPrototype(new Assessment());
        return $assessment;
    }

}
