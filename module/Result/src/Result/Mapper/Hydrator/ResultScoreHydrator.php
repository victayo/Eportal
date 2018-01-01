<?php


namespace Result\Mapper\Hydrator;

use Result\Mapper\Exception\InvalidArgumentException;
use Result\Model\ResultScoreInterface;
use Result\Service\AssessmentServiceInterface;
use Result\Service\ResultServiceInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * Description of ResultScoreHydrator
 *
 * @author imaleo
 */
class ResultScoreHydrator extends ClassMethods{
    protected $resultService;
    protected $assessmentService;
    
    public function __construct(ResultServiceInterface $resultService, AssessmentServiceInterface $assessmentService){
        parent::__construct();
        $this->resultService = $resultService;
        $this->assessmentService = $assessmentService;
    }
    
    /**
     * 
     * @param ResultScoreInterface $object
     * @return array
     * @throws InvalidArgumentException
     */
    public function extract($object)
    {
        if(!$object instanceof ResultScoreInterface){
            throw new InvalidArgumentException('$object must be an instance Result\Model\ResultScoreInterface');
        }
        $data = parent::extract($object);
        $data['result'] = $object->getResult()->getId();
        $data['assessment'] = $object->getAssessment()->getId();
        return $data;
    }
    
    /**
     * 
     * @param array $data
     * @param ResultScoreInterface $object
     * @return ResultScoreInterface
     * @throws InvalidArgumentException
     */
    public function hydrate(array $data, $object){
        if(!$object instanceof ResultScoreInterface){
            throw new InvalidArgumentException('$object must be an instance \Result\Model\ResultScoreInterface');
        }
        $data['result'] = $this->resultService->findById($data['result']);
        $data['assessment'] = $this->assessmentService->findById($data['assessment']);
        return parent::hydrate($data, $object);
    }
    
    public function getResultService() {
        return $this->resultService;
    }

    public function getAssessmentService() {
        return $this->assessmentService;
    }

    public function setResultService($resultService) {
        $this->resultService = $resultService;
        return $this;
    }

    public function setAssessmentService($assessmentService) {
        $this->assessmentService = $assessmentService;
        return $this;
    }


}
