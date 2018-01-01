<?php

namespace ResultTest\Service;

use Exception;
use Result\Model\Assessment;
use Result\Model\Result;
use Result\Model\ResultScore;
use Result\Service\ResultDetailService;
use ResultTest\Bootstrap;
use ResultTest\Mapper\DataGenerator;
use Zend\Db\Adapter\Adapter;

/**
 * @author imaleo
 */
class ResultDetailServiceTest extends \PHPUnit_Framework_TestCase {

    protected $resultService;
    protected $resultScoreService;
    protected $gradeService;
    protected $resultDetails;
    protected $subjects, $sessions, $terms;

    public function setUp() {
        parent::setUp();
        $this->resultService = $this->getMockBuilder('Result\Service\ResultService')
                ->disableOriginalConstructor()
                ->getMock();
        $this->resultScoreService = $this->getMockBuilder('Result\Service\ResultScoreService')
                ->disableOriginalConstructor()
                ->getMock();
        $this->gradeService = $this->getMockBuilder('Result\Service\GradeService')
                ->disableOriginalconstructor()
                ->getMock();
        $this->resultDetails = new ResultDetailService($this->resultService, $this->resultScoreService, $this->gradeService);
//        $this->setUpHelp();
    }

    public function testGetAverage() {
        $qty = 4;
        $scores = array(49, 80, 46, 100);
        $exam = 1;
        $this->resultService->expects($this->once())
                ->method('getResult')
                ->will($this->returnValue(new Result()));
        $rsd = $this->getResultScoreData($qty, $scores, $exam);
        $this->resultScoreService->expects($this->once())
                ->method('getResultScore')
                ->will($this->returnValue($rsd));
        $average = $this->resultDetails->getAverage(1, 1, 1, 1);
        var_dump($average);
        $this->assertNotNull($average);
        $this->assertEquals(round($average['average']), 75);
        $this->assertEquals(round($average['overall_average']), 62);
    }

    public function testGetCumulativeWhenTermIsNotGiven() {
        $qty = 4;
        $scores_a = array(49, 80, 46, 100);
        $scores_b = array(48, 29, 29, 75);
        $scores_c = array(93, 54, 10, 89);
        $exam = 1;
        $this->resultService->expects($this->exactly(3))
                ->method('getResult')
                ->will($this->returnValue(new Result()));
        $this->resultService->expects($this->once())
                ->method('getTerm')
                ->will($this->returnValue(array(1, 2, 3)));
        $rsd_a = $this->getResultScoreData($qty, $scores_a, $exam);
        $rsd_b = $this->getResultScoreData($qty, $scores_b, $exam);
        $rsd_c = $this->getResultScoreData($qty, $scores_c, $exam);
        $this->resultScoreService->expects($this->exactly(3))
                ->method('getResultScore')
                ->will($this->onConsecutiveCalls($rsd_a, $rsd_b, $rsd_c));
        $cumulative = $this->resultDetails->getCumulative(1, 1, 1);
        var_dump($cumulative);
        $this->assertNotNull($cumulative);
    }

    public function testGetClassAverage() {
        $students = array(1, 2, 3, 4, 5);
        $this->resultDetails = $this->getMockBuilder('Result\Service\ResultDetailService')
                ->setMethods(array('getCumulative'))
                ->setConstructorArgs(array($this->resultService, $this->resultScoreService, $this->gradeService))
                ->getMock();
        $this->resultDetails->expects($this->exactly(5))
                ->method('getCumulative')
                ->will($this->onConsecutiveCalls(62, 46, 59, 72, 72));
        $classAve = $this->resultDetails->getClassAverage($students, 1, 1, 1);
        var_dump($classAve);
        $this->assertNotNull($classAve);
    }

    public function testGetPosition() {
        $this->resultDetails = $this->getMockBuilder('Result\Service\ResultDetailService')
                ->setMethods(array('getOverallCumulative'))
                ->setConstructorArgs(array($this->resultService, $this->resultScoreService, $this->gradeService))
                ->getMock();
        $allStudents = array(1,2,3,4,5);
        $this->resultDetails->expects($this->any())
                ->method('getOverallCumulative')
                ->will($this->onConsecutiveCalls(62, 46, 59, 72, 72));
        $position = $this->resultDetails->getPosition($allStudents, 5, 1, 1);
        $this->assertEquals($position, 1);
        $this->assertFalse($this->resultDetails->getPosition($allStudents, 0, 1, 1));
    }
    private function getResultScoreData($qty = 4, $scores = array(), $exams = 1) {
        $resultScores = [];
        if (!$qty) {
            return $resultScores;
        }
        for ($i = 0; $i < $qty; $i++) {
            $resultScore = new ResultScore();
            $score = empty($scores) ? $score = rand(10, 100) : $scores[$i];
            $result = new Result();
            $result->setId($i + 1);
            $assessment = new Assessment();
            $assessment->setId($i + 1)
                    ->setIsExam(0)
                    ->setIncludeInCumulative(1)
                    ->setName('assessment_' . $i + 1)
                    ->setMaxScore(100);
            $resultScore->setResult($result)
                    ->setAssessment($assessment)
                    ->setScore($score);
            $resultScores[] = $resultScore;
        }
        for ($i = 0; $i < $exams; $i++) {
            $resultScores[$i]->getAssessment()->setIsExam(1)->setName('Exam_' . $i + 1);
        }
        return $resultScores;
    }

    protected function setUpAdapter($driver = null) {
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

    protected function setUpDatabase($adapter, $schemaPath, $tableName, $dataFile) {
        $queryStack = array('DROP TABLE IF EXISTS ' . $tableName);
        $queryStack = array_merge($queryStack, explode(';', file_get_contents($schemaPath)));
        $queryStack = array_merge($queryStack, explode(';', file_get_contents($dataFile)));

        foreach ($queryStack as $query) {
            if (!preg_match('/\S+/', $query)) {
                continue;
            }
            $adapter->query($query, $adapter::QUERY_MODE_EXECUTE);
        }
    }

    private function setUpHelp() {
        $adapter = $this->setUpAdapter();
        $serviceManager = Bootstrap::getServiceManager();
        $serviceManager->setAllowOverride(TRUE);
        $serviceManager->setService('Zend\Db\Adapter\Adapter', $adapter);
        
        $this->resultService = $serviceManager->get('Result\Service\Result');
        $this->resultScoreService = $serviceManager->get('Result\Service\ResultScore');
        $this->gradeService = $serviceManager->get('Result\Service\Grade');

        $this->resultDetails = new ResultDetailService($this->resultService, $this->resultScoreService, $this->gradeService);

        $this->subjects = array(24, 25, 28, 29, 30);
        $this->sessions = array(40);
        $this->terms = array(44, 45, 46);
        
        $resultDataFile = 'C:\xampp\htdocs\Eportal\module\Result\tests\ResultTest\Mapper\_files\result.sql';
        $resultScoreDataFile = 'C:\xampp\htdocs\Eportal\module\Result\tests\ResultTest\Mapper\_files\result_score.sql';
        DataGenerator::$resultInArray = true;
        DataGenerator::loadResult($resultDataFile, $this->subjects, $this->sessions, $this->terms);
        $results = DataGenerator::getLoadedResult();
        DataGenerator::loadResultScore($resultScoreDataFile, $results);
        $resultScoreSchema = constant('DB_MYSQL_RESULT_SCORE_SCHEMA');
        $resultSchema = constant('DB_MYSQL_RESULT_SCHEMA');
        $this->setUpDatabase($adapter, $resultScoreSchema, 'result_score', $resultScoreDataFile);
        $this->setUpDatabase($adapter, $resultSchema, 'result', $resultDataFile);
    }

}
