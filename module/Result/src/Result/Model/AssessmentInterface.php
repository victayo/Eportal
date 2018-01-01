<?php
namespace Result\Model;

/**
 *
 * @author imaleo
 *        
 */
interface AssessmentInterface
{

    public function getId();

    public function setId($id);

    public function getName();

    public function setName($name);

    public function getMaxScore();

    public function setMaxScore($maxScore);

    public function setIsExam($exam);

    public function getIsExam();

    public function setIncludeInCumulative($includeInCumulative);

    public function getIncludeInCumulative();
    
    /*
     * @todo Assessments should be grouped/registered as per session and term bases
     * so that a term in a session can have unique assessments
     */
//     private function getSession();

//     private function setSession($session);

//     private function getTerm();

//     private function setTerm($term);
        
}

