<?php

namespace Result\Service;

use Result\Mapper\ResultScoreMapperInterface;
use Result\Model\ResultScore;
use Result\Model\ResultScoreInterface;

/**
 *
 * @author imaleo
 */
class ResultScoreService implements ResultScoreServiceInterface {
    /**
     *
     * @var ResultScoreMapperInterface
     */
    protected $mapper;
    
    public function __construct(ResultScoreMapperInterface $mapper) {
        $this->mapper = $mapper;
    }

    public function getEntity(){
        return new ResultScore();
    }
    
    public function getResultScore($result, $assessment= null) {
        return $this->mapper->getResultScore($result, $assessment);
    }

    public function delete(ResultScoreInterface $resultScore, $where = null) {
        if(!$where){
            $where = array('assessment = ?' => $resultScore->getAssessment(), 'result = ?' => $resultScore->getResult());
        }
        return $this->mapper->delete($where);
    }

    public function findByAssessment($assessment) {
        return $this->mapper->findByAssessment($assessment);
    }

    public function findByResult($result) {
        return $this->mapper->findByResult($result);
    }

    public function insert(ResultScoreInterface $resultScore) {
        return $this->mapper->insert($resultScore);
    }

    public function update(ResultScoreInterface $resultScore, $where = null) {
        if(!$where){
            $where = array('assessment = ?' => $resultScore->getAssessment(), 'result = ?' => $resultScore->getResult());
        }
        return $this->mapper->update($resultScore, $where);
    }

}
