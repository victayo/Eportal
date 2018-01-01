<?php


namespace ResultTest\Mapper;

use Result\Mapper\ResultScoreMapper;
use Result\Model\ResultScore;

/**
 * Description of ResultScoreMapperTest
 *
 * @author imaleo
 */
class ResultScoreMapperTest extends AbstractResultMapperTest{
    protected $hydrator;
    protected $resultScoreMapper;
    
    public function setUp() {
        parent::setUp();
        $this->tableName = 'result_score';
        $this->schema = 'result_score_schema';
        $this->hydrator = $this->getMockBuilder('Result\Mapper\Hydrator\ResultScoreHydrator')
                ->disableOriginalConstructor(true)
                ->getMock();
        $this->resultScoreMapper = new ResultScoreMapper();
        $this->resultScoreMapper->setEntityPrototype(new ResultScore())
                ->setHydrator($this->hydrator);
    }
    
    public function testFindByResult() {
        
    }
}
