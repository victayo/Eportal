<?php
namespace Result\Model;

/**
 *
 * @author imaleo
 *        
 */
interface GradeInterface
{
    public function getId();
    public function setId($id);
    public function getMin();
    public function setMin($min);
    public function getMax();
    public function setMax($max);
    public function getGrade();
    public function setGrade($grade);
    public function getRemark();
    public function setRemark($remark);
}

