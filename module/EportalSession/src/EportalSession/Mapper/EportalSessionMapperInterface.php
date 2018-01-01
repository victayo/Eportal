<?php

namespace EportalSession\Mapper;

/**
 *
 * @author imaleo
 */
interface EportalSessionMapperInterface {

    public function getTerms($session);
    
    public function addTerm($session, $term);

    public function hasTerm($session, $term);
    
    public function removeTerm($session, $term);
    
    public function removeSession($session);
    
    public function getUnmappedTerms($session);
}
