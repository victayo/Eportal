<?php
namespace ResultTest\Mapper;

use Zend\Db\Adapter\Adapter;

/**
 * Description of AbstractResultMapperTest
 *
 * @author imaleo
 */
class AbstractResultMapperTest extends \PHPUnit_Framework_TestCase{
    
    protected $dataFile;
    protected $realAdapter;
    protected $tableName;
    protected $schema;
    private $drivers;

    public function setUpTest($tableName, $schema, $dataFile, array $drivers = array('mysql')){
        $this->tableName = $tableName;
        $this->schema = $schema;
        $this->dataFile = $dataFile;
        $this->drivers = $drivers;
        foreach($drivers as $driver){
            $this->setUpAdapter($driver);
        }
    }
    
    protected function setUpSqlDatabase($adapter, $schemaPath) {
        $queryStack = array('DROP TABLE IF EXISTS '.$this->tableName);
        $queryStack = array_merge($queryStack, explode(';', file_get_contents($schemaPath)));
        $queryStack = array_merge($queryStack, explode(';', file_get_contents($this->dataFile)));

        foreach ($queryStack as $query) {
            if (!preg_match('/\S+/', $query)) {
                continue;
            }
            $adapter->query($query, $adapter::QUERY_MODE_EXECUTE);
        }
    }
    
    protected function setUpAdapter($driver) {
        $upCase = strtoupper($driver);
        $schema = strtoupper($this->schema);
        if (!defined(sprintf('DB_%s_DSN', $upCase)) ||
                !defined(sprintf('DB_%s_USERNAME', $upCase)) ||
                !defined(sprintf('DB_%s_PASSWORD', $upCase)) ||
                !defined(sprintf('DB_%s_'.$schema, $upCase))
        ) {
            return false;
        }

        try {
            $connection = array(
                'driver' => sprintf('Pdo_%s', ucfirst($driver)),
                'dsn' => constant(sprintf('DB_%s_DSN', $upCase))
            );
            if (constant(sprintf('DB_%s_USERNAME', $upCase)) !== "") {
                $connection['username'] = constant(sprintf('DB_%s_USERNAME', $upCase));
                $connection['password'] = constant(sprintf('DB_%s_PASSWORD', $upCase));
            }
            $adapter = new Adapter($connection);
            $this->setUpSqlDatabase($adapter, constant(sprintf('DB_%s_'.$schema, $upCase)));
            $this->realAdapter[$driver] = $adapter;
        } catch (\Exception $e) {
            $this->realAdapter[$driver] = false;
        }
    }
    
    public function getDataFile() {
        return $this->dataFile;
    }

    public function getRealAdapter() {
        return $this->realAdapter;
    }

    public function getTableName() {
        return $this->tableName;
    }

    public function getSchema() {
        return $this->schema;
    }

    public function setDataFile($dataFile) {
        $this->dataFile = $dataFile;
        return $this;
    }

    public function setTableName($tableName) {
        $this->tableName = $tableName;
        return $this;
    }

    public function setSchema($schema) {
        $this->schema = $schema;
        return $this;
    }
    
    public function getDrivers() {
        return $this->drivers;
    }

    public function setDrivers($drivers) {
        $this->drivers = $drivers;
        return $this;
    }


}
