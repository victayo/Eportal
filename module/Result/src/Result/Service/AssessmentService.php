<?php

namespace Result\Service;

use Result\Mapper\AssessmentMapperInterface;
use Result\Model\AssessmentInterface;

/**
 * Description of AssessmentService
 *
 * @author imaleo
 */
class AssessmentService implements AssessmentServiceInterface{
    
    /**
     *
     * @var AssessmentMapperInterface
     */
    protected $mapper;
    
    public function __construct(AssessmentMapperInterface $mapper) {
        $this->mapper = $mapper;
    }
    
    public function getAll() {
        return $this->mapper->getAll();
    }
    
    public function delete(AssessmentInterface $assessment) {
        $where = array('id = ?'=>$assessment->getId());
        return $this->mapper->delete($where);
    }

    public function findById($assessment_id) {
        return $this->mapper->findById($assessment_id);
    }

    public function insert(AssessmentInterface $assessment) {
        return $this->mapper->insert($assessment);
    }

    public function update(AssessmentInterface $assessment, $where = null) {
        if(!$where){
            $where = array('id = ?'=>$assessment->getId());
        }
        return $this->mapper->update($assessment, $where);
    }

    public function getMapper() {
        return $this->mapper;
    }

    public function setMapper(AssessmentMapperInterface $mapper) {
        $this->mapper = $mapper;
        return $this;
    }


}
