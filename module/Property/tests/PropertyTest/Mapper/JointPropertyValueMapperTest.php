<?php

namespace PropertyTest\Mapper;

/**
 * Description of JointPropertyValueMapperTest
 *
 * @author imaleo
 */

use Property\Mapper\Hydrator\RelPropertyValueHydrator;
use Property\Mapper\RelPropertyValueMapper;
use Property\Model\RelPropertyValue;
use Property\Model\PropertyValue;
use PropertyTest\Mapper\Model\JpvTestModel;
use PropertyTest\Mapper\Model\PvTestModel;
use Zend\Stdlib\Hydrator\ClassMethods;

class JointPropertyValueMapperTest extends AbstractPropertyMapperTest {

    /**
     *
     * @var RelPropertyValueMapper
     */
    protected $mapper;

    /**
     *
     * @var RelPropertyValueHydrator
     */
    protected $hydrator;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp() {
        parent::setUp();
        $this->mapper = new RelPropertyValueMapper();
        $this->mapper->setEntityPrototype(new RelPropertyValue());
        $this->hydrator = $this->getMockBuilder('Property\Mapper\Hydrator\JointPropertyValueHydrator')
                ->disableOriginalConstructor()
                ->getMock();
        $this->mapper->setHydrator($this->hydrator)
                ->setDbAdapter($this->getAdapter());
        $this->loadJointPropertyValues();
    }

    public function testFindById() {
        $jpvs = $this->getJointPropertyValues();
        $id = rand(1, count($jpvs));
        $jpv = explode(',', $jpvs[$id - 1]);
        $fpv = new PropertyValue($jpv[0]);
        $spv = new PropertyValue($jpv[1]);
        $entity = new RelPropertyValue($id, $fpv, $spv);
        $this->hydrator->expects($this->once())
                ->method('hydrate')
                ->will($this->returnValue($entity));
        $this->mapper->setHydrator($this->hydrator);

        $result = $this->mapper->findById($id);
        $this->assertNotNull($result);
        $this->assertInstanceOf('Property\Model\JointPropertyValueInterface', $result);
        $this->assertSame($result, $entity);
    }

    public function testFindByFirstPropertyValue() {
        $fpvId = 8; //all general department
        $this->mapper->setHydrator(new ClassMethods())
                ->setEntityPrototype(new JpvTestModel());
        $expectedOutcome = array(30,31,32,33,34,35);
        $results = $this->mapper->findByParent($fpvId);
        $realOutcome = [];
        foreach($results as $result){
            $realOutcome[] = $result->getId();
        }
        
        $this->assertNotNull($results);
        $this->assertEquals($expectedOutcome, $realOutcome);
    }
    
    public function testFindFirstPropertyValue(){
        $this->loadPropertyTable();
        $this->loadPropertyValueTable();
        $this->mapper->setHydrator(new ClassMethods())
                ->setEntityPrototype(new JpvTestModel())
                ->setPropertyValueHydrator(new ClassMethods())
                ->setPropertyValueEntity(new PvTestModel());
        //get classes that has section sectionId 37 mapped to it
        $property = 3; //class
        $spv = 37; //section
        $expectedOutcome = array(15,16,17); //i.e classes with id in expected outcome has sectionId 37
        $results = $this->mapper->findParent($property, $spv);
        $realOutcome = [];
        foreach($results as $result){
//            \Zend\Debug\Debug::dump($result);
            $realOutcome[] = $result->getId();
        }
        $this->assertTrue($results->count()>0);
        $this->assertEquals($expectedOutcome, $realOutcome);
    }
    
    public function testFindSecondPropertyValue() {
        $this->loadPropertyTable();
        $this->loadPropertyValueTable();
        $this->mapper->setHydrator(new ClassMethods())
                ->setEntityPrototype(new JpvTestModel())
                ->setPropertyValueHydrator(new ClassMethods())
                ->setPropertyValueEntity(new PvTestModel());
        //get classes that is registered to school schoolId 1
        $property = 3;
        $fpv = 1;
        $expectedOutcome = array(12,13,14);
        $results = $this->mapper->findChildPropertyValue($property, $fpv);
        $realOutcome = [];
        foreach($results as $result){
            $realOutcome[] = $result->getId();
        }
        $this->assertTrue($results->count()>0);
        $this->assertEquals($expectedOutcome, $realOutcome);
    }
    
    public function testHasPropertyValue() {
        $jpvs = $this->getJointPropertyValues();
        $count = count($jpvs);
        $id = rand(1, $count);
        $jpv = explode(',',$jpvs[$id-1]);
        $this->mapper->setHydrator(new ClassMethods())
                ->setEntityPrototype(new JpvTestModel());
        $result = $this->mapper->hasRelPropertyValue($jpv[0], $jpv[1]);
        $this->assertTrue($result);
        $result = $this->mapper->hasRelPropertyValue(rand($count+1, $count+10), rand($count+11, $count+21));
        $this->assertFalse($result);
    }
    
    public function testFindJointPropertyValue(){
        $jpvs = $this->getJointPropertyValues();
        $id = rand(1, count($jpvs));
        $jpv = explode(',',$jpvs[$id-1]);
        $this->mapper->setHydrator(new ClassMethods())
                ->setEntityPrototype(new JpvTestModel());
        $entity = new JpvTestModel($id, $jpv[0], $jpv[1]);
        $result = $this->mapper->findRelPropertyValue($jpv[0], $jpv[1]);
        $this->assertEquals($result, $entity);
    }
    
    /**
     * @todo Tests involving hardcoded values should be automated somehow. Go figure!
     */
}
