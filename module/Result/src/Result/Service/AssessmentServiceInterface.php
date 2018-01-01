<?php
namespace Result\Service;

use Result\Model\AssessmentInterface;

/**
 *
 * @author imaleo
 *        
 */
interface AssessmentServiceInterface
{
    public function getAll();

    public function findById($assessment_id);
        
    public function insert(AssessmentInterface $assessment);
    
    public function update(AssessmentInterface $assessment, $where);
    
    public function delete(AssessmentInterface $assessment);
}
