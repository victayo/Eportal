<?php

namespace EportalProperty\Service;

/**
 *
 * @author imaleo
 */
class EportalPropertyUtilService {
    
    public function propertyToArray(PropertyInterface $property) {
        if (!$property) {
            return null;
        }
        return array(
            'id' => $property->getId(),
            'name' => $property->getName()
        );
    }
    
    public function propertyValueToArray(PropertyValueInterface $propertyValue, $includeProperty = false) {
        if (!$propertyValue) {
            return null;
        }
        $return = array(
            'id' => $propertyValue->getId(),
            'value' => $propertyValue->getValue()
        );
        if ($includeProperty) {
            $property = $propertyValue->getProperty();
            $return['property'] = $this->propertyToArray($property);
        }
        return $return;
    }
}
