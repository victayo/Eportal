<?php
namespace Property\Mapper\Hydrator;

use Property\Mapper\Exception\InvalidArgumentException;
use Property\Model\PropertyValueInterface;
use Property\Service\PropertyServiceInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 *
 * @author imaleo
 *        
 */
class PropertyValueHydrator extends ClassMethods
{
    private $propertyService;
    
    public function __construct(PropertyServiceInterface $propertyService){
        parent::__construct();
        $this->propertyService = $propertyService;
    }

    public function extract($object)
    {
        if(!$object instanceof PropertyValueInterface){
            throw new InvalidArgumentException('$object must be an instance Property\Model\PropertyValueInterface');
        }
        $data = parent::extract($object);
        $data['property'] = $object->getProperty()->getId();
        return $data;
    }
    
    /**
     * @see ClassMethods::hydrate()
     * @return PropertyValueInterface
     */
    public function hydrate(array $data, $object){
        if(!$object instanceof PropertyValueInterface){
            throw new InvalidArgumentException('$object must be an instance Property\Model\PropertyValueInterface');
        }
        $data['property'] = $this->propertyService->findById($data['property']);
        return parent::hydrate($data, $object);
    }
    
    public function getPropertyService()
    {
        return $this->propertyService;
    }
    
    public function setPropertyService(PropertyServiceInterface $propertyService)
    {
        $this->propertyService = $propertyService;
        return $this;
    }
}

?>