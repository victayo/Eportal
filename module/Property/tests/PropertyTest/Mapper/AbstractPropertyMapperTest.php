<?php

namespace PropertyTest\Mapper;

use Exception;
use Zend\Db\Adapter\Adapter;
/**
 * Description of AbstractPropertyMapperTest
 *
 * @author imaleo
 */
abstract class AbstractPropertyMapperTest extends \PHPUnit_Framework_TestCase{

    protected $propertySchemaPath = "C:/xampp/htdocs/Eportal/module/Property/data/property.schema.mysql.sql";
    protected $propertyValueSchemaPath = "C:/xampp/htdocs/Eportal/module/Property/data/property_value.schema.mysql.sql";
    protected $jointPropertyValueSchemaPath = "C:/xampp/htdocs/Eportal/module/Property/data/joint_property_value.schema.mysql.sql";
    protected $propertyFile = __DIR__ . '/_files/property.txt';
    protected $propertyValueFile = __DIR__ . '/_files/property_value.txt';
    protected $jointPropertyValueFile = __DIR__ . '/_files/joint_property_value.txt';
    protected $adapter;
    protected $properties;
    protected $propertyValues;
    protected $jointPropertyValues;
    
    public function loadPropertyTable($adapter = null, $propertyFile = null, $schemaPath = null) {
        if (!$schemaPath) {
            $schemaPath = $this->propertySchemaPath;
        }
        if (!$propertyFile) {
            $propertyFile = $this->propertyFile;
        }
        if (!$adapter) {
            $adapter = $this->getAdapter();
        }
        $queryStack = array('DROP TABLE IF EXISTS property');
        $queryStack = array_merge($queryStack, explode(';', file_get_contents($schemaPath)));
        $properties = $this->getProperties($propertyFile);
        $queryStack = array_merge($queryStack, $this->getPropertyInsertStatement($properties));
        foreach ($queryStack as $query) {
            if (!preg_match('/\S+/', $query)) {
                continue;
            }
            $adapter->query($query, $adapter::QUERY_MODE_EXECUTE);
        }
    }

    public function getProperties($propertyFile = null) {
        if(!$propertyFile){
            $propertyFile = $this->getPropertyFile();
        }
        if(!$this->properties){
            $this->properties = explode(PHP_EOL, file_get_contents($propertyFile));
        }
        return $this->properties;
    }
    
    public function loadPropertyValueTable($adapter = null, $propertyValueFile = null, $schemaPath = null) {
        if (!$schemaPath) {
            $schemaPath = $this->propertyValueSchemaPath;
        }
        if (!$propertyValueFile) {
            $propertyValueFile = $this->propertyValueFile;
        }
        if (!$adapter) {
            $adapter = $this->getAdapter();
        }
        $queryStack = array('DROP TABLE IF EXISTS property_value');
        $queryStack = array_merge($queryStack, explode(';', file_get_contents($schemaPath)));
        $propertyValues = $this->getPropertyValues($propertyValueFile);
        $queryStack = array_merge($queryStack, $this->getPropertyValueInsertStatement($propertyValues));
        foreach ($queryStack as $query) {
            if (!preg_match('/\S+/', $query)) {
                continue;
            }
            $adapter->query($query, $adapter::QUERY_MODE_EXECUTE);
        }
    }

    
    public function getPropertyValues($pvFile = null) {
        if(!$pvFile){
            $pvFile = $this->getPropertyValueFile();
        }
        if(!$this->propertyValues){
            $this->propertyValues = explode(PHP_EOL, file_get_contents($pvFile));
        }
        return $this->propertyValues;
    }

    public function loadJointPropertyValues($adapter = null, $jpvFile = null, $schemaPath = null) {
        if (!$schemaPath) {
            $schemaPath = $this->jointPropertyValueSchemaPath;
        }
        if (!$jpvFile) {
            $jpvFile = $this->jointPropertyValueFile;
        }
        if (!$adapter) {
            $adapter = $this->getAdapter();
        }
        $queryStack = array('DROP TABLE IF EXISTS joint_property_value');
        $queryStack = array_merge($queryStack, explode(';', file_get_contents($schemaPath)));
        $jpvs = $this->getJointPropertyValues($jpvFile);
        $queryStack = array_merge($queryStack, $this->getJointPropertyValueInsertStatement($jpvs));
        foreach ($queryStack as $query) {
            if (!preg_match('/\S+/', $query)) {
                continue;
            }
            $adapter->query($query, $adapter::QUERY_MODE_EXECUTE);
        }
    }

    public function getJointPropertyValues($jpvFile = null){
        if(!$jpvFile){
            $jpvFile = $this->getJointPropertyValueFile();
        }
        if(!$this->jointPropertyValues){
            $this->jointPropertyValues = explode(PHP_EOL, file_get_contents($jpvFile));
        }
        return $this->jointPropertyValues;
    }
    public function setUpAdapter($driver = null) {
        if (!$driver) {
            $driver = 'mysql';
        }
        $upCase = strtoupper($driver);
        try {
            $connection = array(
                'dsn' => constant(sprintf('DB_%s_DSN', $upCase)),
                'driver' => sprintf('Pdo_%s', ucfirst($driver)),
            );
            if (constant(sprintf('DB_%s_USERNAME', $upCase)) !== "") {
                $connection['username'] = constant(sprintf('DB_%s_USERNAME', $upCase));
                $connection['password'] = constant(sprintf('DB_%s_PASSWORD', $upCase));
            }
            $adapter = new Adapter($connection);
            return $adapter;
        } catch (Exception $e) {
            return null;
        }
    }

    public function getAdapter($driver = null) {
        if (!$this->adapter) {
            $this->adapter = $this->setUpAdapter($driver);
        }
        return $this->adapter;
    }

    public function setAdapter($adapter) {
        $this->adapter = $adapter;
    }

    public function getPropertySchemaPath() {
        return $this->propertySchemaPath;
    }

    public function getPropertyValueSchemaPath() {
        return $this->propertyValueSchemaPath;
    }

    public function getJointPropertyValueSchemaPath() {
        return $this->jointPropertyValueSchemaPath;
    }

    public function getPropertyFile() {
        return $this->propertyFile;
    }

    public function getPropertyValueFile() {
        return $this->propertyValueFile;
    }

    public function getJointPropertyValueFile() {
        return $this->jointPropertyValueFile;
    }

    public function setPropertySchemaPath($propertySchemaPath) {
        $this->propertySchemaPath = $propertySchemaPath;
        return $this;
    }

    public function setPropertyValueSchemaPath($propertyValueSchemaPath) {
        $this->propertyValueSchemaPath = $propertyValueSchemaPath;
        return $this;
    }

    public function setJointPropertyValueSchemaPath($jointPropertyValueSchemaPath) {
        $this->jointPropertyValueSchemaPath = $jointPropertyValueSchemaPath;
        return $this;
    }

    public function setPropertyFile($propertyFile) {
        $this->propertyFile = $propertyFile;
        return $this;
    }

    public function setPropertyValueFile($propertyValueFile) {
        $this->propertyValueFile = $propertyValueFile;
        return $this;
    }

    public function setJointPropertyValueFile($jointPropertyValueFile) {
        $this->jointPropertyValueFile = $jointPropertyValueFile;
        return $this;
    }

    private function getPropertyValueInsertStatement($propertyValues) {
        $statements = [];  
        foreach ($propertyValues as $propertyValue) {
            if (!preg_match('/\S+/', $propertyValue)) {
                continue;
            }
            $pv = explode(',', $propertyValue);
            $statements[] = "insert into `property_value` (`property`, `value`) values ('{$pv[0]}', '$pv[1]');";
        }
        return $statements;
    }

    private function getJointPropertyValueInsertStatement($jpvs) {
        $statements = [];
        foreach ($jpvs as $jpv) {
            if (!preg_match('/\S+/', $jpv)) {
                continue;
            }
            $ex = explode(',', $jpv);
            $statements[] = "insert into joint_property_value (first_property_value, second_property_value) values ('{$ex[0]}', '$ex[1]');";
        }
        return $statements;
    }

    private function getPropertyInsertStatement($properties) {
        $statements = [];
        foreach ($properties as $property) {
            if (!preg_match('/\S+/', $property)) {
                continue;
            }
            $statements[] = "insert into property (name) values ('{$property}');";
        }
        return $statements;
    }

}
