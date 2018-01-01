<?php

namespace EportalTerm\Service;

use Property\Model\PropertyValueInterface;

/**
 *
 * @author OKALA
 */
interface EportalTermServiceInterface {

    public function saveTerm(PropertyValueInterface $term);

    public function deleteTerm(PropertyValueInterface $term);

    public function getTerm($termId =null);

    public function getTermProperty();
}
