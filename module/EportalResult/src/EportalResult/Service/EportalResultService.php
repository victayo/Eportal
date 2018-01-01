<?php

namespace EportalResult\Service;

use EportalUser\Model\EportalUserInterface;
use Property\Service\PropertyValueServiceInterface;
use Result\Service\AssessmentServiceInterface;
use Result\Service\ResultDetailService;
use Result\Service\ResultScoreServiceInterface;
use Result\Service\ResultServiceInterface;

/**
 *
 * @author imaleo
 */
class EportalResultService {

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
     * @var ResultDetailService
     */
    protected $resultDetailService;

    /**
     *
     * @var AssessmentServiceInterface
     */
    protected $assessmentService;
    
    /**
     *
     * @var PropertyValueServiceInterface
     */
    protected $propertyValueService;
    public function __construct(ResultServiceInterface $resultService, 
            ResultDetailService $resultDetailService,
            ResultScoreServiceInterface $resultScoreService,
            AssessmentServiceInterface $assessmentService, 
            PropertyValueServiceInterface $propertyValueService) {
        $this->resultService = $resultService;
        $this->resultScoreService = $resultScoreService;
        $this->resultDetailService = $resultDetailService;
        $this->assessmentService = $assessmentService;
        $this->propertyValueService = $propertyValueService;
    }

        public function getResultAssessment(EportalUserInterface $user, $session, $term, $subject) {
        $result = $$this->resultService->getResult($user, $session, $term, $subject);
        $resultScores = $this->resultScoreService->getResultScore($result);
        $assessments = [];
        foreach ($resultScores as $resultScore) {
            $assessments[$resultScore->getAssessment()->getName()] = $resultScore->getScore();
        }
        return $assessments;
    }

    public function getResult($student, $session, $term, $subject, $assessments = []) {
        if (empty($assessments)) {
            $assessments = $this->assessmentService->getAll();
        }
        $assessmentArr = [];
        foreach ($assessments as $assessment) {
            $result = $this->resultService->getResult($student, $session, $term, $subject);
            $assessmentArr[] = [
                'assessment_id' => $assessment->getId(),
                'assessment_name' => $assessment->getName(),
                'score' => $this->resultScoreService->getResultScore($result, $assessment)->current()->getScore()
            ];
        }
        $subjectPv = $this->propertyValueService->findById($subject);
        $return = [
            'subject_id' => $subject,
            'subject_name' => $subjectPv->getValue(),
            'assessment' => $assessmentArr,
            'average' => $this->resultDetailService->getAverage($student, $session, $term, $subject),
            'cumulative' => $this->resultDetailService->getCumulative($student, $subject, $session),
            'grade' => '',
            'remark' => ''
        ];
        return $return;
    }

}
