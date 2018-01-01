<?php
namespace Result\Mapper;

/**
 *
 * @author imaleo
 *        
 */
interface GradeMapperInterface extends ResultInterface
{
    public function getGrade($grade);
    
    public function getAll();
    
    public function findById($id);
}

