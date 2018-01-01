<?php
namespace Result\Service;

use Result\Model\ResultScoreInterface;
/**
 *
 * @author imaleo
 *        
 */
interface ResultScoreServiceInterface
{
    public function getResultScore($result, $assessment = null);
        
    public function getEntity();
    
    public function findByAssessment($assessment);
    
    public function findByResult($result);
    
    public function insert(ResultScoreInterface $resultScore);
    
    public function update(ResultScoreInterface $resultScore, $where = null);
    
    public function delete(ResultScoreInterface $resultScore, $where = null);
}
