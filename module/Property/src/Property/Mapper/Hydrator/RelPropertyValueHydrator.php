<?php
namespace Property\Mapper\Hydrator;

use Property\Mapper\Exception\InvalidArgumentException;
use Property\Model\RelPropertyValueInterface;
use Property\Service\PropertyValueServiceInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 *
 * @author imaleo
 *        
 */
class RelPropertyValueHydrator extends ClassMethods
{

    private $propertyValueService;

    /**
     *
     * @param bool|array $underscoreSeparatedKeys            
     *
     */
    public function __construct(PropertyValueServiceInterface $propertyValueService, $underscoreSeparatedKeys = true)
    {
        parent::__construct($underscoreSeparatedKeys);
        $this->propertyValueService = $propertyValueService;
    }

    public function hydrate(array $data, $object)
    {
        if (! $object instanceof RelPropertyValueInterface) {
            throw new InvalidArgumentException("$object must be an instance Property\Model\RelPropertyValueInterface");
        }
        $data['parent'] = $this->propertyValueService->findById($data['parent']);
        $data['property_value'] = $this->propertyValueService->findById($data['property_value']);
        return parent::hydrate($data, $object);
    }

    public function extract($object)
    {
        if (! $object instanceof RelPropertyValueInterface) {
            throw new InvalidArgumentException("$object must be an instance Property\Model\RelPropertyValueInterface");
        }
        $data = parent::extract($object);
        $data['parent'] = $object->getParent()->getId();
        $data['property_value'] = $object->getPropertyValue()->getId();
        return $data;
    }
    
    public function getPropertyValueService(){
        return $this->propertyValueService;
    }
    
    public function setPropertyValueService(PropertyValueServiceInterface $propertyValueService)
    {
        $this->propertyValueService = $propertyValueService;
        return $this;
    }
}
