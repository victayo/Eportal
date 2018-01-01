<?php

namespace EportalSchool\Service;

use EportalSchool\Mapper\EportalSchoolMapperInterface;
use Property\Model\PropertyValueInterface;
use Property\Service\PropertyServiceInterface;
use Property\Service\PropertyValueServiceInterface;

/**
 *
 * @author imaleo
 */
class EportalSchoolService implements EportalSchoolServiceInterface{
    
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
    
    /**
     *
     * @var EportalSchoolMapperInterface
     */
    protected $eportalSchoolMapper;
    
    public function __construct(EportalSchoolMapperInterface $eportalSchoolMapper, PropertyValueServiceInterface $propertyValueService, PropertyServiceInterface $propertyService) {
        $this->propertyValueService = $propertyValueService;
        $this->propertyService = $propertyService;
        $this->eportalSchoolMapper = $eportalSchoolMapper;
    }

    public function addClass($school, $class) {
        return $this->eportalSchoolMapper->addClass($this->propertyValueService->toId($school), $this->propertyValueService->toId($class));
    }

    public function deleteSchool($school) {
        $this->eportalSchoolMapper->removeSchool($this->propertyValueService->toId($school));
        $this->propertyValueService->delete($school);
    }

    public function getClasses($school) {
        return $this->eportalSchoolMapper->getClasses($this->propertyValueService->toId($school));
    }

    public function getSchool($school_id = null) {
        if($school_id){
            return $this->propertyValueService->findById($school_id);
        }
        return $this->propertyValueService->findByProperty($this->propertyService->findByName('school'));
    }

    public function getSchoolProperty() {
        return $this->propertyService->findByName('school');
    }

    public function getUnmappedClasses($school) {
        return $this->eportalSchoolMapper->getUnmappedClasses($this->propertyValueService->toId($school));
    }

    public function hasClass($school, $class) {
        return $this->eportalSchoolMapper->hasClass($this->propertyValueService->toId($school), $this->propertyValueService->toId($class));
    }

    public function removeClass($school, $class) {
        return $this->eportalSchoolMapper->removeClass($this->propertyValueService->toId($school), $this->propertyValueService->toId($class));
    }

    public function saveSchool(PropertyValueInterface $school) {
        return $this->propertyValueService->save($school);
    }

    public function getPropertyValueService() {
        return $this->propertyValueService;
    }

    public function getPropertyService() {
        return $this->propertyService;
    }

    public function getEportalSchoolMapper() {
        return $this->eportalSchoolMapper;
    }

    public function setPropertyValueService(PropertyValueServiceInterface $propertyValueService) {
        $this->propertyValueService = $propertyValueService;
        return $this;
    }

    public function setPropertyService(PropertyServiceInterface $propertyService) {
        $this->propertyService = $propertyService;
        return $this;
    }

    public function setEportalSchoolMapper(EportalSchoolMapperInterface $eportalSchoolMapper) {
        $this->eportalSchoolMapper = $eportalSchoolMapper;
        return $this;
    }
}
