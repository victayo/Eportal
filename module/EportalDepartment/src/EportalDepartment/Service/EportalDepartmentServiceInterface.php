<?php

namespace EportalDepartment\Service;

use Property\Model\PropertyValueInterface;

/**
 *
 * @author OKALA
 */
interface EportalDepartmentServiceInterface {

    public function saveDepartment(PropertyValueInterface $department);

    public function deleteDepartment(PropertyValueInterface $department);

    public function getDepartment($departmentId = null);

    public function getDepartmentProperty();

    public function getSubject($school, $class, $department);

    public function addSubject($school, $class, $department, $subject);

    public function removeSubject($school, $class, $department, $subject);

    public function hasSubject($school, $class, $department, $subject);

    public function getSchool($department);

    public function getClass($school, $department);
    
    public function getUnaddedSubject($school, $class, $department);
}
