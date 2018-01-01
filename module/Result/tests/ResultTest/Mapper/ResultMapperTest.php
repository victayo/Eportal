<?php

namespace ResultTest\Mapper;

use Result\Mapper\ResultMapper;
use Result\Model\Result;
use Zend\Stdlib\Hydrator\ClassMethods;

//use ResultTest\Mapper\AbstractResultMapperTest;
/**
 * Description of ResultMapperTest
 *
 * @author imaleo
 */
class ResultMapperTest extends AbstractResultMapperTest {

    /**
     *
     * @var ResultMapper
     */
    protected $resultMapper;
    private $subjects;
    private $sessions;
    private $terms;
    private $totalUsers;
    protected $dataFile = __DIR__ . "\\_files\\result.sql";

    public function setUp() {
        parent::setUp();
        $this->tableName = 'result';
        $this->schema = 'result_schema';

        $this->subjects = array('english', 'maths', 'physics', 'chemistry', 'biology');
        $this->sessions = array('2012/2013');
        $this->terms = array('first', 'second', 'third');
        $this->totalUsers = 5;
//        $this->subjects = array(24, 25, 28, 29, 30);
//        $this->sessions = array(40);
//        $this->terms = array(44, 45, 46);

        $this->resultMapper = new ResultMapper();
        $this->resultMapper->setEntityPrototype(new Result())
                ->setHydrator(new ClassMethods());
    }

    protected function setUpDataGenerator($storeAsArray = false) {
        DataGenerator::$resultInArray = $storeAsArray;
        DataGenerator::loadResult($this->dataFile, $this->subjects, $this->sessions, $this->terms, $this->totalUsers);
    }

    public function testFindById() {
        $this->setUpDataGenerator(TRUE);
        $this->setUpTest($this->tableName, $this->schema, $this->dataFile);
        $resultArr = DataGenerator::getLoadedResult();
        $result_id = rand(0, (count($resultArr) - 1));
        foreach ($this->realAdapter as $dbAdapter) {
            $this->resultMapper->setDbAdapter($dbAdapter);
            $resultDb = $this->resultMapper->findById($result_id + 1);
            $result = $resultArr[$result_id];
            $this->assertEquals($resultDb->getSubject(), $result['subject']);
            $this->assertEquals($resultDb->getUser(), $result['user']);
            $this->assertEquals($resultDb->getSession(), $result['session']);
            $this->assertEquals($resultDb->getTerm(), $result['term']);
        }
    }

    public function testGetResultWhenSubjectIsNotNullAndNotArray() {
        $this->setUpDataGenerator(true);
        $this->setUpTest($this->tableName, $this->schema, $this->dataFile);
        $resultArr = DataGenerator::getLoadedResult();
        $result_id = rand(0, (count($resultArr) - 1));
        $result = $resultArr[$result_id];
        foreach ($this->realAdapter as $dbAdapter) {
            $this->resultMapper->setDbAdapter($dbAdapter);
            $resultDb = $this->resultMapper->getResult($result['user'], $result['session'], $result['term'], $result['subject']);
            $this->assertEquals($resultDb->getId(), $result_id+1);
        }
    }
    
    public function testGetResultWhenSubjectIsNotNullAndIsArray() {
        $this->setUpDataGenerator(true);
        $this->setUpTest($this->tableName, $this->schema, $this->dataFile);
        $resultArr = DataGenerator::getLoadedResult();
        $result_id = rand(0, (count($resultArr) - 1));
        $result = $resultArr[$result_id];
        foreach($this->realAdapter as $dbAdapter){
            $this->resultMapper->setDbAdapter($dbAdapter);
            $resultDb = $this->resultMapper->getResult($result['user'], $result['session'], $result['term'], $this->subjects);
            foreach($resultDb as $res) {
                $id = $res->getId();
                $this->assertEquals($res->getSubject(), $resultArr[$id-1]['subject']);
            }
        }
    }

    public function testGetResultWhenSubjectIsNull() {
        $this->setUpDataGenerator(true);
        $this->setUpTest($this->tableName, $this->schema, $this->dataFile);
        $resultArr = DataGenerator::getLoadedResult();
        $result_id = rand(0, (count($resultArr) - 1));
        $result = $resultArr[$result_id];
        foreach($this->realAdapter as $dbAdapter){
            $this->resultMapper->setDbAdapter($dbAdapter);
            $resultDb = $this->resultMapper->getResult($result['user'], $result['session'], $result['term']);
            $this->assertEquals(count($this->subjects), $resultDb->count());
            foreach($resultDb as $res) {
                $this->assertTrue(in_array($res->getSubject(), $this->subjects)); 
            }
        }
    }
    
    public function testGetSubjectsAndTerm() {
        $this->setUpDataGenerator(true);
        $this->setUpTest($this->tableName, $this->schema, $this->dataFile);
        $resultArr = DataGenerator::getLoadedResult();
        $result_id = rand(0, (count($resultArr) - 1));
        $result = $resultArr[$result_id];
        foreach($this->realAdapter as $dbAdapter){
            $this->resultMapper->setDbAdapter($dbAdapter);
            $subjects = $this->resultMapper->getSubjects($result['user'], $result['session'], $result['term']);
            $this->assertEquals(count($this->subjects), count($subjects));
            $this->assertEquals($this->subjects, $subjects);
            $terms = $this->resultMapper->getTerm($result['user'], $result['subject'], $result['session']);
            $this->assertEquals(count($this->terms), count($terms));
            $this->assertEquals($this->terms, $terms);
        }
    }
}
