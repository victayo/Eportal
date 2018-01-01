<?php
namespace Result\Service;

use Result\Model\AssessmentInterface;
use Result\Model\ResultDetails;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 * @author imaleo
 *        
 */
class ResultDetailService implements ResultDetailServiceInterface, ServiceLocatorAwareInterface
{
    
    protected $serviceLocator;
    /**
     * 
     * @var ResultServiceInterface
     */
    protected $resultService;
    
    /**
     * 
     * @var ResultScoreServiceInterface
     */
    protected $resultScoreService;
    
    /**
     * 
     * @var GradeServiceInterface
     */
    protected $gradeService;

    /**
     *
     * @var RemarkServiceInterface
     */
    protected $remarkService;
    
    /**
     *
     * @var AssessmentServiceInterface
     */
    protected $assessmentService;
    
    
    /**
     *
     * @see ResultDetailServiceInterface::getClassAverage()
     *
     */
    public function getClassAverage($students, $subject, $session, $term)
    {
        $sum = 0;
        $null = 0;
       foreach($students as $student){
           $cumulative = $this->getCumulative($student, $subject, $session, $term);
           if(!$cumulative){
               $null++;
               continue;
           }
           $sum += $cumulative;
       }
       $total = count($students) - $null;
       return $sum/$total;
    }

    public function getAssessment($student, $session, $term, $subject, AssessmentInterface $assessment = null){
        $result = $$this->getResultService()->getResult($student, $session, $term, $subject);
        $resultScores = $this->getResultScoreService()->getResultScore($result, $assessment);
        if($assessment){
            return array(
                $assessment->getName() => $resultScores->getScore()
            );
        }
        $assessments = [];
        foreach ($resultScores as $resultScore){
            $assessments[$resultScore->getAssessment()->getName()] = $resultScore->getScore();
        }
        return $assessments;
    }
    
    public function getAssessmentScore($student, $session, $term, $subject, AssessmentInterface $assessment = null){
        $result = $$this->getResultService()->getResult($student, $session, $term, $subject);
        $resultScores = $this->getResultScoreService()->getResultScore($result, $assessment);
        if($assessment){
//            return array(
//                $assessment->getName() => $resultScores->getScore()
//            );
//            return $resultScores->getScore();
            return [
                'id' => $assessment->getId(),
                'name' => $assessment->getName(),
                'score' => $resultScores->getScore()
            ];
        }
        $assessments = [];
        foreach ($resultScores as $resultScore){
            $ass = $resultScore->getAssessment();
            $assessments[] = [
                'id' => $ass->getId(),
                'name' => $ass->getName(),
                'score' => $resultScore->getScore()
            ];
//            $assessments[$resultScore->getAssessment()->getName()] = $resultScore->getScore();
        }
        return $assessments;
    }
    /**
     *
     * @see ResultDetailServiceInterface::getCumulative()
     *
     */
    public function getCumulative($student, $subject, $session, $terms = null)
    {
        if(!$terms){
            $terms = $this->getResultService()->getTerm($student, $session, $subject);
            if(!$terms){
                return false;
            }
        }else{//convert terms to array if not in array. There should be a better way tho. This doesn't look good
            if(!is_array($terms)){
                $terms = array($terms);
            }
        }
        $presentCumulative = 0;
        $count = 0;
        foreach ($terms as $term){
            $average = $this->getAverage($student, $session, $term, $subject);
            if(!$average){
                continue;
            }
            $overallAverage = $average['overall_average'];
            if($count == 0){
                $presentCumulative = $overallAverage;
            }else{
                $presentCumulative = ($presentCumulative + $overallAverage)/2;
            }
            $count++;
        }
        return $presentCumulative;
    }

    public function getOverallCumulative($student, $session, $term) {
        $subjects = $this->getResultService()->getSubjects($student, $session, $term);
        $sumCumulative = 0;
        foreach ($subjects as $subject) {
            $cumulative = $this->getCumulative($student, $session, $subject, $term);
            $sumCumulative += $cumulative;
        }
        return $sumCumulative;
    }
    
    /**
     *
     * @see ResultDetailServiceInterface::getGrade()
     *
     */
    public function getGrade($student, $subject, $session, $term = null)
    {
        $cumulative = $this->getCumulative($student, $session, $subject, $term);
        return $this->getGradeService()->getGrade($cumulative);
        
    }

    /**
     * (non-PHPdoc)
     *
     * @see ResultDetailServiceInterface::getTeacherRemark()
     *
     */
    public function getTeacherRemark($student, $subject, $session, $term)
    {
        $result = $this->getResultService()->getResult($student, $session, $term, $subject);
        return $this->getRemarkService()->getRemark($result);
    }

    /**
     *
     * @see ResultDetailServiceInterface::getPosition()
     *
     */
    public function getPosition($allStudents, $theStudent, $session, $term)
    {
        if(!in_array($theStudent, $allStudents)){
            return false;
        }
        $cumulatives = [];
        foreach ($allStudents as $student){
            $sumCumulative = $this->getOverallCumulative($student, $session, $term);
            $cumulatives[$student] = $sumCumulative;
        }
        return $this->positionGetter($cumulatives, $theStudent);
    }

    public function getSubjectPosition($allStudents, $student, $subject, $session, $term) {
        if(!in_array($student, $allStudents)){
            return false;
        }
        $cumulatives = [];
        foreach ($allStudents as $student){
            $cumulative = $this->getCumulative($student,$subject, $session, $term);
            if(!$cumulative){
                continue;
            }
            $cumulatives[$student] = $cumulative;
        }
        return $this->positionGetter($cumulatives, $student);
    }
    /**
     *
     * @see ResultDetailServiceInterface::getAverage()
     *
     */
    public function getAverage($student, $session, $term, $subject)
    {
        $result = $this->getResultService()->getResult($student, $session, $term, $subject);
        if(!$result){
            return false;
        }
        $resultScores = $this->getResultScoreService()->getResultScore($result);
        if(!$resultScores){
            return false;
        }
        $sum = 0;
        $count = 0;
        foreach($resultScores as $resultScore) {
            if(!$resultScore->getAssessment()->getIncludeInCumulative()){
                continue;
            }
            if($resultScore->getAssessment()->getIsExam()){
                $examScore = $resultScore->getScore();
                continue;
            }
            $sum += $resultScore->getScore();
            $count++;
        }
        if(!$count){
            return false;
        }
        $average = $sum/$count;
        if($examScore){
            $overallAverage = ($average + $examScore)/2;
        }else{
            $overallAverage = $average;
        }
        
        return array(
            'average' => $average,
            'overall_average' => $overallAverage
        );
    }

    public function getFullResultDetails($student, $subject, $session, $term) {
        $assessments = $this->getAssessmentService()->getAll();
        $ave = $this->getAverage($student, $session, $term, $subject);
        $average = $ave['average'];
        $overallAverage = $ave['overall_average'];
        $cumulative = $this->getCumulative($student, $subject, $session, $term);
        $remark = $this->getTeacherRemark($student, $subject, $session, $term);
        $grade = $this->getGrade($student, $subject, $session, $term);
        $result = $this->getResultService()->getResult($student, $session, $term, $subject);
        $assessmentScores = [];
        $rss = $this->getResultScoreService();
        foreach ($assessments as $assessment) {
            $assessmentScores[$assessment->getName()] = $rss->getResultScore($result, $assessment);
        }
        $resultDetail = new ResultDetails();
        $resultDetail->setAssessmentScores($assessmentScores)
                ->setAverage($average)
                ->setCumulative($cumulative)
                ->setSubject($subject)
                ->setOverallAverage($overallAverage)
                ->setGrade($grade)
                ->setRemark($remark);
        return $resultDetail;
    }
    
    public function getResultService() {
        if(!$this->resultService){
            $this->resultService = $this->getServiceLocator()->get('Result\Service\Result');
        }
        return $this->resultService;
    }

    public function getResultScoreService() {
        if(!$this->resultScoreService){
            $this->resultScoreService = $this->getServiceLocator()->get('Result\Service\ResultScore');
        }
        return $this->resultScoreService;
    }

    public function getGradeService() {
        if(!$this->gradeService){
            $this->gradeService = $this->getServiceLocator()->get('Result\Service\Grade');
        }
        return $this->gradeService;
    }

    public function setResultService(ResultServiceInterface $resultService) {
        $this->resultService = $resultService;
        return $this;
    }

    public function setResultScoreService(ResultScoreServiceInterface $resultScoreService) {
        $this->resultScoreService = $resultScoreService;
        return $this;
    }

    public function setGradeService(GradeServiceInterface $gradeService) {
        $this->gradeService = $gradeService;
        return $this;
    }

    public function setRemarkService(RemarkServiceInterface $remarkService){
        $this->remarkService = $remarkService;
        return $this;
    }
    
    public function getRemarkService(){
        if(!$this->remarkService){
            $this->remarkService = $this->getServiceLocator()->get('Result\Service\Remark');
        }
        return $this->remarkService;
    }

    public function getAssessmentService(){
        if(!$this->assessmentService){
            $this->assessmentService = $this->getServiceLocator()->get('Result\Service\Assessment');
        }
        return $this->assessmentService;
    }
    
    public function setAssessmentService(AssessmentServiceInterface $assessmentService){
        $this->assessmentService = $assessmentService;
        return $this;
    }
    
    public function getServiceLocator() {
        return $this->serviceLocator;
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }

    private function positionGetter($cumulatives, $student) {
        arsort($cumulatives);
        $count = 0; 
        $postion = 0;
        $highestCumulative = PHP_INT_MAX;
        foreach($cumulatives as $key => $cumulative){
            if($cumulative < $highestCumulative){
                $postion = $count+1;
            }
            if($student == $key) {
                return $postion;
            }
            $highestCumulative = $cumulative;
            $count++;
        }
        return null;
    }
    
}
