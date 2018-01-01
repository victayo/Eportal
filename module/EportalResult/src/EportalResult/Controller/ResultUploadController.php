<?php

namespace EportalResult\Controller;

use Result\Service\AssessmentService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

/**
 * @author OKALA
 */
class ResultUploadController extends AbstractActionController {

    /**
     *
     * @var AssessmentService
     */
    protected $assessmentService;

    public function editAction() {
        $request = $this->getRequest();
        $model = new JsonModel();
        if (!$request->isPost()) {
            return $model;
        }
        $property = json_decode($request->getContent(), true);
        $result_data = $this->Result()->getResultData($property);
        $propertyValue = $this->PropertyValue();
        $session = $propertyValue->findById($property['session'], true);
        $term = $propertyValue->findById($property['term'], true);
        $school = $propertyValue->findById($property['school'], true);
        $class = $propertyValue->findById($property['class'], true);
        $subject = $propertyValue->findById($property['subject'], true);
        $department = (isset($property['department'])  && $property['department'])
                ? $propertyValue->findById($property['department'], true) 
                : null;
        $model->setVariables([
            'result_data' => $result_data,
            'session' => $session,
            'term' => $term,
            'class' => $class,
            'school' => $school,
            'department' => $department,
            'subject' => $subject
        ]);
        return $model;
    }

    public function submitAction() {
        $request = $this->getRequest();
        $model = new JsonModel();
        if (!$request->isPost()) {
            return $model;
        }
        $post = json_decode($request->getContent(), true);
        $resultData = $post['result_data'];
        $property = $post['property'];
        $success = $this->result()->save($resultData, $property);
        $model->setVariable('success', $success);
        return $model;
    }

    public function getAssessmentService() {
        if (!$this->assessmentService) {
            $this->assessmentService = $this->getServiceLocator()->get('Result\Service\Assessment');
        }
        return $this->assessmentService;
    }

    public function setAssessmentService(AssessmentService $assessmentService) {
        $this->assessmentService = $assessmentService;
        return $this;
    }

    protected function assessmentToArray($assessments) {
        $assessmentData = [];
        foreach ($assessments as $assessment) {
            $assessmentData[] = [
                'id' => $assessment->getId(),
                'name' => $assessment->getName()
            ];
        }
        return $assessmentData;
    }

}
