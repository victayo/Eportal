<?php

namespace EportalRole\Factory;

use EportalRole\Model\UserRoleLinker;
use EportalRole\Model\UserRoleLinkerTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 * @author imaleo
 */
class UserRoleLinkerFactory implements FactoryInterface {

    protected $tablename = 'user_role_linker';
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $adapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $resultPrototype = new ResultSet();
        $resultPrototype->setArrayObjectPrototype(new UserRoleLinker());
        $tableGateway = new TableGateway($this->tablename, $adapter, null, $resultPrototype);
        $userRoleLinker = new UserRoleLinkerTable($tableGateway);
        return $userRoleLinker;
    }

}
