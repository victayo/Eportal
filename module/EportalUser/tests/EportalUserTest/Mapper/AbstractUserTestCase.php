<?php

namespace EportalUserTest\Mapper;

use Zend\Db\Adapter\Adapter;

/**
 *
 * @author imaleo
 */
class AbstractUserTestCase extends \PHPUnit_Framework_TestCase{
    
    public function getAdapter($driver = null) {
        if (!$driver) {
            $driver = 'mysql';
        }
        $connection = array(
            'dsn' => "mysql:host=localhost;dbname=eportal_test",
            'driver' => sprintf('Pdo_%s', ucfirst($driver)),
            'username' => 'root',
            'password' => ''
        );
        return new Adapter($connection);
    }
}
