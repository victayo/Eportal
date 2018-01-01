<?php
namespace Result\Service;

/**
 *
 * @author imaleo
 *        
 */
interface GradeServiceInterface
{
    /**
     * 
     * @param double $score
     * @return \Result\Model\GradeInterface
     */
    public function getGrade($score);
    
    public function insert(\Result\Model\GradeInterface $grade);
    
    public function update(\Result\Model\GradeInterface $grade, $where);
    
    public function delete(\Result\Model\GradeInterface $grade);
    
    public function getAll();
    
    public function findById($id);
}

