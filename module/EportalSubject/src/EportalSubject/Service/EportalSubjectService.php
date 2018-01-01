<?php


namespace EportalSubject\Service;

use EportalSubject\Mapper\EportalSubjectMapperInterface;
use Property\Model\PropertyValueInterface;
use Property\Service\PropertyServiceInterface;
use Property\Service\PropertyValueServiceInterface;

/**
 * @author OKALA
 */
class EportalSubjectService implements EportalSubjectServiceInterface{
    
     /**
     *
     * @var EportalSubjectMapperInterface
     */
    protected $eportalSubjectMapper;

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
    
    public function __construct(EportalSubjectMapperInterface $eportalSubjectMapper, PropertyValueServiceInterface $propertyValueService, PropertyServiceInterface $propertyService) {
        $this->eportalSubjectMapper = $eportalSubjectMapper;
        $this->propertyValueService = $propertyValueService;
        $this->propertyService = $propertyService;
    }
    public function deleteSubject(PropertyValueInterface $department) {
        /**
         * @todo All relationships with parent should be deleted. Events?
         */
        $this->propertyValueService->delete($department);
    }

    public function getSubject($subjectId = null) {
        if(!$subjectId){
            $property = $this->propertyService->findByName('subject');
            return $this->propertyValueService->findByProperty($property);
        }
        return $this->propertyValueService->findById($subjectId);
    }

    public function getSubjectProperty() {
        return $this->propertyService->findByName('subject');
    }

    public function saveSubject(PropertyValueInterface $subject) {
        return $this->propertyValueService->save($subject);
    }

    public function getEportalSubjectMapper() {
        return $this->eportalSubjectMapper;
    }

    public function getPropertyValueService() {
        return $this->propertyValueService;
    }

    public function getPropertyService() {
        return $this->propertyService;
    }

    public function setEportalSubjectMapper(EportalSubjectMapperInterface $eportalSubjectMapper) {
        $this->eportalSubjectMapper = $eportalSubjectMapper;
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
