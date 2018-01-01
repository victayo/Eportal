<?php

namespace Result\Model;

/**
 *
 * @author imaleo
 */
class ResultDetails {

    protected $subject;
    protected $assessmentScores;
    protected $average;
    protected $overallAverage;
    protected $cumulative;
    protected $lastCumulative;
    protected $classAverage;
    protected $position;
    protected $grade;
    protected $remark;

    public function getSubject() {
        return $this->subject;
    }

    public function getGrade() {
        return $this->grade;
    }

    public function getRemark() {
        return $this->remark;
    }

    public function setGrade($grade) {
        $this->grade = $grade;
        return $this;
    }

    public function setRemark($remark) {
        $this->remark = $remark;
        return $this;
    }

    public function getAssessmentScores() {
        return $this->assessmentScores;
    }

    public function getAverage() {
        return $this->average;
    }

    public function getOverallAverage() {
        return $this->overallAverage;
    }

    public function getCumulative() {
        return $this->cumulative;
    }

    public function getLastCumulative() {
        return $this->lastCumulative;
    }

    public function getClassAverage() {
        return $this->classAverage;
    }

    public function getPosition() {
        return $this->position;
    }

    public function setSubject($subject) {
        $this->subject = $subject;
        return $this;
    }

    public function setAssessmentScores($assessmentScores) {
        $this->assessmentScores = $assessmentScores;
        return $this;
    }

    public function setAverage($average) {
        $this->average = $average;
        return $this;
    }

    public function setOverallAverage($overallAverage) {
        $this->overallAverage = $overallAverage;
        return $this;
    }

    public function setCumulative($cumulative) {
        $this->cumulative = $cumulative;
        return $this;
    }

    public function setLastCumulative($lastCumulative) {
        $this->lastCumulative = $lastCumulative;
        return $this;
    }

    public function setClassAverage($classAverage) {
        $this->classAverage = $classAverage;
        return $this;
    }

    public function setPosition($position) {
        $this->position = $position;
        return $this;
    }

    public function toArray(){
        return array(
            'subject' => $this->getSubject(),
            'assessment_scores' => $this->getAssessmentScores(),
            'position' => $this->getPosition(),
            'average' => $this->getAverage(),
            'overall_average' => $this->getOverallAverage(),
            'class_average' => $this->getClassAverage(),
            'cumulative' => $this->getCumulative(),
            'last_cumulative' => $this->getLastCumulative(),
            'grade' => $this->getGrade(),
            'remark' => $this->getRemark(),
        );
    }
}
