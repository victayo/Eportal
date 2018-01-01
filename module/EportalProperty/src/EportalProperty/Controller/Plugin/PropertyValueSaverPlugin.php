<?php

namespace EportalProperty\Controller\Plugin;

use Eportal\Controller\Plugin\AbstractEportalControllerPlugin;
use Exception;

/**
 *
 * @author imaleo
 */
class PropertyValueSaverPlugin extends AbstractEportalControllerPlugin {
    
    public function save($propertyValues, $propertyValue, $propertyValuePosition) {
        $this->beginTransaction();
        try {
            $this->saveHandler($propertyValues, $propertyValue, $propertyValuePosition);
            $this->commit();
            return true;
        } catch (Exception $ex) {
            $this->rollBack();
            return false;
        }
    }

    public function saveMultiple($arguments) {
        $this->beginTransaction();
        try {
            foreach ($arguments as $arg) {
                $this->saveHandler($arg['property_values'], $arg['property_value'], $arg['position']);
            }
            $this->commit();
            return true;
        } catch (Exception $ex) {
            $this->rollBack();
            return false;
        }
    }

    protected function saveHandler($propertyValues, $propertyValue, $propertyValuePosition) {
        $controller = $this->getController();
        $pvService = $controller->getEportalPropertyValueService()->getPropertyValueService();
        $rpvService = $controller->getEportalRelPropertyValueService()->getRelPropertyValueService();
        $pvService->insert($propertyValue);
        foreach ($propertyValues as $propVal) {
            $pv = $pvService->findById($propVal);
            $jpv = $propertyValuePosition == 'first' ? $rpvService->getEntity(NULL, $propertyValue, $pv) :
                    $rpvService->getEntity(NULL, $pv, $propertyValue);
            $rpvService->insert($jpv);
        }
    }

}
