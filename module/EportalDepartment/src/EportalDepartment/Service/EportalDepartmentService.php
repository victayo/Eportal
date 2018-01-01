<?php


namespace EportalDepartment\Service;

use EportalDepartment\Mapper\EportalDepartmentMapperInterface;
use Property\Model\PropertyValueInterface;
use Property\Service\PropertyServiceInterface;
use Property\Service\PropertyValueServiceInterface;

/**
 * @author OKALA
 */
class EportalDepartmentService implements EportalDepartmentServiceInterface{
    
     /**
     *
     * @var EportalDepartmentMapperInterface
     */
    protected $eportalDepartmentMapper;

    /**
     *
     * @var PropertyValueServiceInterface
     */
    protected $propertyValueService;

    /**
     *
     * @var PropertyServiceInterface
     */
    protected $propertyService;
    
    public function __construct(EportalDepartmentMapperInterface $eportalDepartmentMapper, PropertyValueServiceInterface $propertyValueService, PropertyServiceInterface $propertyService) {
        $this->eportalDepartmentMapper = $eportalDepartmentMapper;
        $this->propertyValueService = $propertyValueService;
        $this->propertyService = $propertyService;
    }

    public function addSubject($school, $class, $department, $subject) {
        return $this->eportalDepartmentMapper->addSubject($school, $class, $department, $subject);
    }

    public function deleteDepartment(PropertyValueInterface $department) {
        $dept = $department->getId();
        $schools = $this->eportalDepartmentMapper->getSchool($dept);
        foreach($schools as $school){
            $classes = $this->eportalDepartmentMapper->getClass($school, $dept);
            foreach($classes as $class){//remove classes
                $subjects = $this->eportalDepartmentMapper->getSubject($school, $class, $dept);
                foreach ($subjects as $subject){//remove subjects
                    $this->eportalDepartmentMapper->removeSubject($school, $class, $dept, $subject);
                }
                $this->eportalDepartmentMapper->removeDepartment($school, $class, $dept);
            }
        }
        $this->propertyValueService->delete($department);
    }

    public function getClass($school, $department) {
        return $this->eportalDepartmentMapper->getClass($school, $department);
    }

    public function getDepartment($departmentId = null) {
        if(!$departmentId){
            $property = $this->propertyService->findByName('department');
            return $this->propertyValueService->findByProperty($property);
        }
        return $this->propertyValueService->findById($departmentId);
    }

    public function getDepartmentProperty() {
        return $this->propertyService->findByName('department');
    }

    public function getSchool($department) {
        return $this->eportalDepartmentMapper->getSchool($department);
    }

    public function getSubject($school, $class, $department) {
        return $this->eportalDepartmentMapper->getSubject($school, $class, $department);
    }

    public function getUnaddedSubject($school, $class, $department) {
        return $this->eportalDepartmentMapper->getUnaddedSubject($school, $class, $department);
    }

    public function hasSubject($school, $class, $department, $subject) {
        return $this->eportalDepartmentMapper->hasSubject($school, $class, $department, $subject);
    }

    public function removeSubject($school, $class, $department, $subject) {
        return $this->eportalDepartmentMapper->removeSubject($school, $class, $department, $subject);
    }

    public function saveDepartment(PropertyValueInterface $department) {
        return $this->propertyValueService->save($department);
    }

    public function getEportalDepartmentMapper() {
        return $this->eportalDepartmentMapper;
    }

    public function getPropertyValueService() {
        return $this->propertyValueService;
    }

    public function getPropertyService() {
        return $this->propertyService;
    }

    public function setEportalDepartmentMapper(EportalDepartmentMapperInterface $eportalDepartmentMapper) {
        $this->eportalDepartmentMapper = $eportalDepartmentMapper;
        return $this;
    }

    public function setPropertyValueService(PropertyValueServiceInterface $propertyValueService) {
        $this->propertyValueService = $propertyValueService;
        return $this;
    }

    public function setPropertyService(PropertyServiceInterface $propertyService) {
        $this->propertyService = $propertyService;
        return $this;
    }


}
