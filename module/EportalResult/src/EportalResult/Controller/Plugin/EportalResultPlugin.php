<?php

namespace EportalResult\Controller\Plugin;

use Eportal\Controller\Plugin\AbstractEportalControllerPlugin;
use EportalSubject\Service\EportalSubjectUserServiceInterface;
use Exception;
use Result\Service\AssessmentServiceInterface;
use Result\Service\ResultScoreServiceInterface;
use Result\Service\ResultServiceInterface;

/**
 *
 * @author imaleo
 */
class EportalResultPlugin extends AbstractEportalControllerPlugin {

    /**
     *
     * @var ResultServiceInterface
     */
    protected $resultService;

    /**
     *
     * @var AssessmentServiceInterface
     */
    protected $assessmentService;

    /**
     *
     * @var ResultScoreServiceInterface
     */
    protected $resultScoreService;

    /**
     *
     * @var EportalSubjectUserServiceInterface
     */
    protected $eportalSubjectUserService;

    public function save($resultData, $property) {
        $this->beginTransaction();
        $resultService = $this->getResultService();

        $assessments = $this->getAssessmentService()->getAll()->toArray();
        $resultScoreService = $this->getResultScoreService();
        $session = $property['session'];
        $term = $property['term'];
        $subject = $property['subject'];
        try {
            foreach ($resultData as $data) {
                $student_id = $data['student_id'];
                $result = $resultService->getResult($student_id, $session, $term, $subject);
                if (!$result) {
                    $result = $resultService->getEntity();
                    $result->setSession($session)
                            ->setTerm($term)
                            ->setUser($student_id)
                            ->setSubject($subject)
                            ->setDate(date('Y-m-d'));
                    $resultService->insert($result);
                }
                foreach ($assessments as $assessment) {
                    $assessmentId = $assessment['id'];
                    $score = $data['assessment_' . $assessmentId];
                    $resultScore = $resultScoreService->getResultScore($result->getId(), $assessmentId);
                    if (!count($resultScore)) {
                        $resultScore = $resultScoreService->getEntity();
                        $resultScore->setResult($result->getId())
                                ->setAssessment($assessmentId)
                                ->setScore($score);
                        $resultScoreService->insert($resultScore);
                    } else {
                        $resultScore = $resultScore->current();
                        $resultScore->setScore($score);
                        $resultScoreService->update($resultScore);
                    }
                }
            }
            $this->commit();
            return true;
        } catch (Exception $ex) {
            $this->rollBack();
            return false;
        }
    }

    public function getResultData($property) {
        $session = $property['session'];
        $term = $property['term'];
        $school = $property['school'];
        $department = isset($property['department']) ? $property['department'] : null;
        $class = $property['class'];
        $subject = $property['subject'];
        $students = $this->getEportalSubjectUserService()->getUsers($session, $term, $school, $class, $department, $subject);
        $resultData = [];
        foreach ($students as $student) {
            $studentId = $student->getId();
            $data = [
                'student_id' => $studentId,
                'student_username' => $student->getUsername(),
                'student_name' => $student->fullname(),
            ];
            $assessmentData = $this->getAssessmentData($studentId, $session, $term, $subject);
            $resultData[] = array_merge($data, $assessmentData);
        }
        return $resultData;
    }

    public function getViewData($student, $session, $term) {
        $subjects = $this->getEportalSubjectUserService()->getSubjects($student, $session, $term);
        $viewData = [];
        foreach ($subjects as $subject) {
            $data = [
                'subject_id' => $subject->getId(),
                'subject_name' => $subject->getValue(),
            ];
            $assessmentData = $this->getAssessmentData($student, $session, $term, $subject->getid());
            $viewData[] = array_merge($data, $assessmentData);
        }
        return $viewData;
    }

    public function deleteResult($studentData, $session, $term, $subject) {
        $this->beginTransaction();
        $resultService = $this->getResultService();
        try {
            foreach ($studentData as $data) {
                $student = $data['student']['id'];
                $result = $resultService->getResult($student, $session, $term, $subject);
                $resultService->delete($result);
            }
            $this->commit();
            return true;
        } catch (Exception $e) {
            $this->rollBack();
            return false;
        }
    }

    public function getResultService() {
        if (!$this->resultService) {
            $this->resultService = $this->getServiceLocator()->get('Result\Service\Result');
        }
        return $this->resultService;
    }

    public function getAssessmentService() {
        if (!$this->assessmentService) {
            $this->assessmentService = $this->getServiceLocator()->get('Result\Service\Assessment');
        }
        return $this->assessmentService;
    }

    public function getResultScoreService() {
        if (!$this->resultScoreService) {
            $this->resultScoreService = $this->getServiceLocator()->get('Result\Service\ResultScore');
        }
        return $this->resultScoreService;
    }

    public function getEportalSubjectUserService() {
        if (!$this->eportalSubjectUserService) {
            $this->eportalSubjectUserService = $this->getServiceLocator()->get('EportalSubject\Service\EportalSubjectUser');
        }
        return $this->eportalSubjectUserService;
    }

    public function setEportalSubjectUserService(EportalSubjectUserServiceInterface $eportalSubjectUserService) {
        $this->eportalSubjectUserService = $eportalSubjectUserService;
        return $this;
    }

    protected function getAssessmentData($user, $session, $term, $subject) {
        $resultService = $this->getResultService();
        $resultScoreService = $this->getResultScoreService();
        $assessments = $this->getAssessmentService()->getAll()->toArray();
        $data = [];
        $result = $resultService->getResult($user, $session, $term, $subject);
        $resultId = !$result ? null : $result->getId();
        foreach ($assessments as $assessment) {
            $assessmentId = $assessment['id'];
            if (!$resultId) {
                $score = null;
            } else {
                $score = $resultScoreService->getResultScore($resultId, $assessmentId)->current()->getScore();
            }
            $data['assessment_' . $assessmentId] = $score;
        }
        return $data;
    }

}
