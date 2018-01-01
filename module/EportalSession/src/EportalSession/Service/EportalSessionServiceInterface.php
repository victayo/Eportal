<?php

namespace EportalSession\Service;

use Property\Model\PropertyValueInterface;

/**
 *
 * @author imaleo
 */
interface EportalSessionServiceInterface {
    
public function getSessionProperty();

public function getSession($session_id = null);

public function saveSession(PropertyValueInterface $session);

public function deleteSession($session);

public function getTerms($session);

public function addTerm($session, $term);

public function removeTerm($session, $term);

public function hasTerm($session, $term);

public function getUnmappedTerms($session);
}
