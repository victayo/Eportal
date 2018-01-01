<?php

namespace EportalProperty\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

/**
 * @author OKALA
 */
class EportalPropertyAPI extends AbstractRestfulController{
    
    public function get($id) {
        $pv = $this->PropertyValue()->findById($id, true);
        return new JsonModel([$pv]);
    }

    public function getList() {
        $property = $this->params()->fromQuery('property');
        if (!$property) {
            return $this->redirect()->toRoute(null, ['action' => 'not-found']);
        }
        $property = $this->Property()->findByName($property);
        return new JsonModel($this->PropertyValue()->findByProperty($property)->toArray());
    }
    
}
