<?php


namespace EportalTerm\Service;

use EportalTerm\Mapper\EportalTermMapperInterface;
use Property\Model\PropertyValueInterface;
use Property\Service\PropertyServiceInterface;
use Property\Service\PropertyValueServiceInterface;

/**
 * @author OKALA
 */
class EportalTermService implements EportalTermServiceInterface{
    
     /**
     *
     * @var EportalTermMapperInterface
     */
    protected $eportalTermMapper;

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
    
    public function __construct(EportalTermMapperInterface $eportalTermMapper, PropertyValueServiceInterface $propertyValueService, PropertyServiceInterface $propertyService) {
        $this->eportalTermMapper = $eportalTermMapper;
        $this->propertyValueService = $propertyValueService;
        $this->propertyService = $propertyService;
    }
    public function deleteTerm(PropertyValueInterface $department) {
        /**
         * @todo All relationships with parent should be deleted. Events?
         */
        $this->propertyValueService->delete($department);
    }

    public function getTerm($termId = null) {
        if(!$termId){
            $property = $this->propertyService->findByName('term');
            return $this->propertyValueService->findByProperty($property);
        }
        return $this->propertyValueService->findById($termId);
    }

    public function getTermProperty() {
        return $this->propertyService->findByName('term');
    }

    public function saveTerm(PropertyValueInterface $term) {
        return $this->propertyValueService->save($term);
    }

    public function getEportalTermMapper() {
        return $this->eportalTermMapper;
    }

    public function getPropertyValueService() {
        return $this->propertyValueService;
    }

    public function getPropertyService() {
        return $this->propertyService;
    }

    public function setEportalTermMapper(EportalTermMapperInterface $eportalTermMapper) {
        $this->eportalTermMapper = $eportalTermMapper;
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
