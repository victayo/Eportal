<?php

namespace Eportal\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

/**
 *
 * @author imaleo
 */
abstract class AbstractEportalControllerPlugin extends AbstractPlugin{
    protected $connection;
    protected $serviceLocator;
    
    public function getConnection() {
        if (!$this->connection) {
            $serviceLocator = $this->getController()->getServiceLocator();
            $db = $serviceLocator->get('Zend\Db\Adapter\Adapter');
            $this->connection = $db->getDriver()->getConnection();
        }
        return $this->connection;
    }

    public function setConnection($connection) {
        $this->connection = $connection;
        return $this;
    }

    protected function beginTransaction() {
        $this->getConnection()->beginTransaction();
    }

    protected function rollBack() {
        $this->getConnection()->rollBack();
    }

    protected function commit() {
        $this->getConnection()->commit();
    }
    
    protected function getServiceLocator(){
        if(!$this->serviceLocator){
            $this->serviceLocator = $this->getController()->getServiceLocator();
        }
        return $this->serviceLocator;
    }
}
