<?php
namespace Result\Mapper;

/**
 *
 * @author imaleo
 *        
 */
interface AssessmentMapperInterface extends ResultInterface
{
    public function getAll();
    public function findById($assessment_id);
    


//    private function findBySession($session_id);
//    
//    private function findByTerm($term_id);
}

