<?php

namespace EportalSession\Service;

use EportalSession\Mapper\EportalSessionMapperInterface;
use Property\Model\PropertyValueInterface;
use Property\Service\PropertyServiceInterface;
use Property\Service\PropertyValueServiceInterface;

/**
 *
 * @author imaleo
 */
class EportalSessionService implements EportalSessionServiceInterface{
    
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
     * @var EportalSessionMapperInterface
     */
    protected $eportalSessionMapper;
    
    public function __construct(EportalSessionMapperInterface $eportalSessionMapper, PropertyValueServiceInterface $propertyValueService, PropertyServiceInterface $propertyService) {
        $this->propertyValueService = $propertyValueService;
        $this->propertyService = $propertyService;
        $this->eportalSessionMapper = $eportalSessionMapper;
    }

    public function addTerm($session, $term) {
        return $this->eportalSessionMapper->addTerm($this->propertyValueService->toId($session), $this->propertyValueService->toId($term));
    }

    public function deleteSession($session) {
        $this->eportalSessionMapper->removeSession($this->propertyValueService->toId($session));
        $this->propertyValueService->delete($session);
    }

    public function getTerms($session) {
        return $this->eportalSessionMapper->getTerms($this->propertyValueService->toId($session));
    }

    public function getSession($session_id = null) {
        if($session_id){
            return $this->propertyValueService->findById($session_id);
        }
        return $this->propertyValueService->findByProperty($this->propertyService->findByName('session'));
    }

    public function getSessionProperty() {
        return $this->propertyService->findByName('session');
    }

    public function getUnmappedterms($session) {
        return $this->eportalSessionMapper->getUnmappedterms($this->propertyValueService->toId($session));
    }

    public function hasTerm($session, $term) {
        return $this->eportalSessionMapper->hasTerm($this->propertyValueService->toId($session), $this->propertyValueService->toId($term));
    }

    public function removeTerm($session, $term) {
        return $this->eportalSessionMapper->removeTerm($this->propertyValueService->toId($session), $this->propertyValueService->toId($term));
    }

    public function saveSession(PropertyValueInterface $session) {
        return $this->propertyValueService->save($session);
    }

    public function getPropertyValueService() {
        return $this->propertyValueService;
    }

    public function getPropertyService() {
        return $this->propertyService;
    }

    public function getEportalSessionMapper() {
        return $this->eportalSessionMapper;
    }

    public function setPropertyValueService(PropertyValueServiceInterface $propertyValueService) {
        $this->propertyValueService = $propertyValueService;
        return $this;
    }

    public function setPropertyService(PropertyServiceInterface $propertyService) {
        $this->propertyService = $propertyService;
        return $this;
    }

    public function setEportalSessionMapper(EportalSessionMapperInterface $eportalSessionMapper) {
        $this->eportalSessionMapper = $eportalSessionMapper;
        return $this;
    }
}
