<?php

namespace Eportal\Service;

use Property\Model\PropertyInterface;
use Property\Model\PropertyValueInterface;

/**
 *
 * @author imaleo
 */
class EportalUtil {

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

    public function propertyValueToFormOptions($propertyValues, $isArray = false) {
        $valueOptions = [];
        if ($isArray) {
            foreach ($propertyValues as $propertyValue) {
                $valueOptions[$propertyValue['id']] = ucwords($propertyValue['value']);
            }
            return $valueOptions;
        }
        foreach ($propertyValues as $propertyValue) {
            $valueOptions[$propertyValue->getId()] = ucwords($propertyValue->getValue());
        }
        return $valueOptions;
    }

    public function propertyValueToOptions($propertyValues) {
        $valueOptions = [];
        foreach ($propertyValues as $propertyValue) {
            $arr = [
                'id' => $propertyValue->getId(),
                'value' => ucwords($propertyValue->getValue())
            ];
            $valueOptions[] = $arr;
        }
        return $valueOptions;
    }

    public function removeDuplicatePropertyValues($propertyValue_a, $propertyValue_b) {
        if (empty($propertyValue_a)) {//$pvB is already unique
            return $propertyValue_b;
        }
        if (empty($propertyValue_b)) {//$pvA is already unique
            return $propertyValue_a;
        }
        $unique = [];
        foreach ($propertyValue_a as $pva) {
            if (!$this->hasPropertyValue($pva, $propertyValue_b)) {
                $unique[] = $pva;
            }
        }
        return $unique;
    }

    public function hasPropertyValue(PropertyValueInterface $propertyValue, $propertyValues) {
        foreach ($propertyValues as $pvs) {
            if ($pvs->getId() == $propertyValue->getId()) {
                return true;
            }
        }
        return false;
    }

    public function studentsToArray($students) {
        $arr = [];
        foreach ($students as $student) {
            $arr[] = array(
                'id' => $student->getId(),
                'name' => $student->fullName(),
                'reg_no' => $student->getUserName(),
                'status' => $student->getStatus(),
            );
        }
        return $arr;
    }

}
