<?php
namespace Result\Model;

/**
 *
 * @author imaleo
 *        
 */
interface ResultScoreInterface
{
    public function getResult();
    public function setResult($result);
    public function getAssessment();
    public function setAssessment($assessment);
    public function setScore($score);
    public function getScore();
}

