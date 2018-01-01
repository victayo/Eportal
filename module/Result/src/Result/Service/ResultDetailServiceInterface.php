<?php
namespace Result\Service;

/**
 *
 * @author imaleo
 *        
 */
interface ResultDetailServiceInterface
{
    
    /**
     * 
     * @param int $student
     * @param int $session
     * @param int $term
     * @param int $subject
     */
    public function getAverage($student, $subject, $session, $term);
    
    /**
     * 
     * @param int $student
     * @param int $session
     * @param array $terms
     * @param int $subject
     */
    public function getCumulative($student, $subject, $session, $terms);
    
    /**
     * 
     * @param unknown $student
     * @param unknown $session
     * @param unknown $term
     */
    public function getOverallCumulative($student, $session, $term);
    
    
    /**
     * 
     * @param array $allStudents
     * @param int $theStudent
     * @param int $session
     * @param int $term
     * Gets the position of $theStudent among $allStudents for a $session and $term
     */
    public function getPosition($allStudents, $theStudent, $session, $term);
    
    /**
     * 
     * @param unknown $allStudents
     * @param unknown $student
     * @param unknown $subject
     * @param unknown $session
     * @param unknown $term
     * @return int the position of $student in $subject
     */
    public function getSubjectPosition($allStudents, $student, $subject, $session, $term);
    
    
    /**
     * 
     * @param array $allStudents
     * @param int $session
     * @param int $term
     * @param int $subject
     * @return double the class average of $allStudents in $subject
     */
    public function getClassAverage($allStudents, $subject, $session, $term);
    
    
    /**
     * 
     * @param int $student
     * @param int $session
     * @param int|array|null $term
     * @param int $subject
     * @return \Result\Model\GradeInterface the grade of $student in $subject
     */
    public function getGrade($student, $subject, $session, $term = null);
    
    
    /**
     * 
     * @param int $student
     * @param int $session
     * @param int $term
     * @param int $subject
     */
    public function getTeacherRemark($student, $subject, $session, $term);
    
    public function getFullResultDetails($student, $subject, $session, $term);
}

