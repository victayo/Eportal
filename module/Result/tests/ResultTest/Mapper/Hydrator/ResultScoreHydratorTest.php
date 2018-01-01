<?php


namespace ResultTest\Mapper\Hydrator;

use Result\Mapper\Hydrator\ResultScoreHydrator;
use Result\Model\Assessment;
use Result\Model\Result;
use Result\Model\ResultScore;

/**
 * Description of ResultScoreHydratorTest
 *
 * @author imaleo
 */
class ResultScoreHydratorTest extends \PHPUnit_Framework_TestCase{
    protected $hydrator;
    protected $resultService;
    protected $assessmentService;
    
    public function setUp(){
        parent::setUp();
        $this->resultService = $this->getMockBuilder('Result\Service\ResultService')
                ->disableOriginalConstructor(true)
                ->getMock();
        $this->assessmentService = $this->getMockBuilder('Result\Service\AssessmentService')
                ->disableOriginalConstructor(true)
                ->getMock();
        $this->hydrator = new ResultScoreHydrator($this->resultService, $this->assessmentService);
    }
    
    public function testHydrate() {
        $result = new Result();
        $assessment = new Assessment();
       
        $result->setId(1)
                ->setSession('2016/2017')
                ->setTerm('first')
                ->setSubject('english');
        $assessment->setId(1)
                ->setIsExam(1)
                ->setIncludeInCumulative(1)
                ->setName('first ca');
        $data = array(
            'result' => $result->getId(),
            'assessment' => $assessment->getId(),
            'score' => rand(0, 100)
        );
        $this->resultService->expects($this->once())
                ->method('findById')
                ->will($this->returnValue($result));
        $this->assessmentService->expects($this->once())
                ->method('findById')
                ->will($this->returnValue($assessment));
        $return = $this->hydrator->hydrate($data, new ResultScore());
        $this->assertEquals($return->getResult()->getId(), $result->getId());
        $this->assertEquals($return->getAssessment()->getId(), $assessment->getId());
        $this->assertInstanceOf('Result\Model\ResultInterface', $return->getResult());
        $this->assertInstanceOf('Result\Model\AssessmentInterface', $return->getAssessment());
    }
    
    public function testExtract() {
        $object = new ResultScore();
        $result = new Result();
        $assessment = new Assessment();
        $result->setId(1)
                ->setSession('2016/2017')
                ->setTerm('first')
                ->setSubject('english');
        $assessment->setId(1)
                ->setIsExam(1)
                ->setIncludeInCumulative(1)
                ->setName('first ca');
        $object->setAssessment($assessment)
                ->setResult($result)
                ->setScore(rand(0, 100));
        $extract = $this->hydrator->extract($object);
        $this->assertEquals($extract['result'], $result->getId());
        $this->assertEquals($extract['assessment'], $assessment->getId());
    }
}
