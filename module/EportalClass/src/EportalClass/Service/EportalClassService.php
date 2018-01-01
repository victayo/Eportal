<?php

namespace EportalClass\Service;

use EportalClass\Mapper\EportalClassMapper;
use EportalClass\Mapper\EportalClassMapperInterface;
use Property\Model\PropertyValueInterface;
use Property\Service\PropertyServiceInterface;
use Property\Service\PropertyValueServiceInterface;

/**
 * Description of EportalClassService
 *
 * @author OKALA
 */
class EportalClassService implements EportalClassServiceInterface {

    /**
     *
     * @var EportalClassMapperInterface
     */
    protected $eportalClassMapper;

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

    public function __construct(EportalClassMapperInterface $eportalClassMapper, PropertyValueServiceInterface $propertyValueService, PropertyServiceInterface $propertyService) {
        $this->eportalClassMapper = $eportalClassMapper;
        $this->propertyValueService = $propertyValueService;
        $this->propertyService = $propertyService;
    }

    public function addDepartment($school, $class, $department) {
        return $this->eportalClassMapper->addDepartment($school, $class, $department);
    }

    public function addSubject($school, $class, $subject) {
        return $this->eportalClassMapper->addSubject($school, $class, $subject);
    }

    public function deleteClass(PropertyValueInterface $class) {
        $schools = $this->eportalClassMapper->getSchools($class->getId());
        foreach($schools as $school){
            $this->eportalClassMapper->removeClass($school->getId(), $class->getId());
        }
        return $this->propertyValueService->delete($class);
    }

    public function getClass($classId = null) {
        if($classId){
            return $this->propertyValueService->findById($classId);
        }
        $property = $this->propertyService->findByName('class');
        return $this->propertyValueService->findByProperty($property);
    }

    public function getClassProperty() {
        return $this->propertyService->findByName('class');
    }

    public function getDepartments($school, $class) {
        return $this->eportalClassMapper->getDepartments($school, $class);
    }

    public function getSchools($class) {
        return $this->eportalClassMapper->getSchools($class);
    }

    public function getSubjects($school, $class) {
        return $this->eportalClassMapper->getSubjects($school, $class);
    }

    public function getUnaddedDepartment($school, $class) {
        return $this->eportalClassMapper->getUnaddedDepartment($school, $class);
    }

    public function getUnaddedSubjects($school, $class) {
        return $this->eportalClassMapper->getUnaddedSubjects($school, $class);
    }

    public function hasDepartment($school, $class, $department) {
        return $this->eportalClassMapper->hasDepartment($school, $class, $department);
    }

    public function hasSubject($school, $class, $subject) {
        return $this->eportalClassMapper->hasSubject($school, $class, $subject);
    }

    public function removeDepartment($school, $class, $department) {
        return $this->eportalClassMapper->removeDepartment($school, $class, $department);
    }

    public function removeSubject($school, $class, $subject) {
        return $this->eportalClassMapper->removeSubject($school, $class, $subject);
    }

    public function saveClass(PropertyValueInterface $class) {
        return $this->propertyValueService->save($class);
    }

    public function getEportalClassMapper() {
        return $this->eportalClassMapper;
    }

    public function getPropertyValueService() {
        return $this->propertyValueService;
    }

    public function getPropertyService() {
        return $this->propertyService;
    }

    public function setEportalClassMapper(EportalClassMapper $eportalClassMapper) {
        $this->eportalClassMapper = $eportalClassMapper;
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
