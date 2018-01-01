<?php

namespace EportalProperty\Model;

/**
 *
 * @author imaleo
 */
class EportalProperty {
    protected $session;
    protected $term;
    protected $school;
    protected $class;
    protected $department;
    protected $subject;

    public function getSchool() {
        return $this->school;
    }

    public function setSchool($school) {
        $this->school = $school;
        return $this;
    }

    public function getClass() {
        return $this->class;
    }

    public function getSession() {
        return $this->session;
    }

    public function getDepartment() {
        return $this->department;
    }

    public function getSubject() {
        return $this->subject;
    }

    public function getTerm() {
        return $this->term;
    }

    public function setClass($class) {
        $this->class = $class;
        return $this;
    }

    public function setSession($session) {
        $this->session = $session;
        return $this;
    }

    public function setDepartment($department) {
        $this->department = $department;
        return $this;
    }

    public function setSubject($subject) {
        $this->subject = $subject;
        return $this;
    }

    public function setTerm($term) {
        $this->term = $term;
        return $this;
    }
}
