<?php

namespace EportalSession\Mapper;

use EportalSession\Mapper\EportalSessionMapperInterface;
use Property\Mapper\AbstractPropertyDbMapper;
use Zend\Db\Sql\Select;

/**
 *
 * @author imaleo
 */
class EportalSessionMapper extends AbstractPropertyDbMapper implements EportalSessionMapperInterface{
    
    public function getTerms($session) {
        $pvTable = self::PROPERTY_VALUE_TABLE;
        $select = $this->getSelect(['session' => $this->tableName])
                ->join(['term' => $this->tableName], 'term.parent = session.id', [], Select::JOIN_LEFT)
                ->join($pvTable, $pvTable . '.id = term.property_value')
                ->where(['session.property_value' => $session])
                ->columns([]);
        return $this->select($select, $this->getPropertyValueEntity(), $this->getPropertyValueHydrator());
    }

    public function addTerm($session, $term){
        $sessionRpv = $this->getRelPropertyValue($session);
        if(!$sessionRpv){
            $sessionRpv = $this->getEntityPrototype()
                    ->setPropertyValue($session);
            $this->save($sessionRpv);
        }
        $parentId = $sessionRpv->getId();
        $insertEntity = $this->getEntityPrototype()
                ->setId(null)
                ->setParent($parentId)
                ->setPropertyValue($term);
        return $this->save($insertEntity);
    }

    public function hasTerm($session, $term) {
        $select = $this->getSelect(['session' => $this->tableName])
                ->join(['term' => $this->tableName], 'term.parent = session.id', [], Select::JOIN_LEFT)
                ->where([
            'session.property_value' => $session,
            'term.property_value' => $term
        ]);
        return boolval($this->select($select)->count());
    }

    public function removeTerm($session, $term) {
        $parent = $this->getRelationship($session, $term);
        $id = $parent->getId();
        if ($id) {
            $this->delete(['id' => $id]);
            return true;
        }
        return false;
    }

    public function removeSession($session){
        $termes = $this->getTerms($session);
        foreach ($termes as $term) {
            $this->removeTerm($session, $term->getId());
        }
        $sessionRpv = $this->getRelPropertyValue($session);
        $this->delete(['id' => $sessionRpv->getId()]);
    }
    
    public function getRelationship($session, $term) {
        $select = $this->getSelect(['session' => $this->tableName])
                ->join(['term' => $this->tableName], 'term.parent = session.id')
                ->where([
                    'session.property_value' => $session,
                    'term.property_value' => $term
                ])
                ->columns([]);
        return $this->select($select)->current();
    }
    
    public function getUnmappedTerms($session){
        $pvTable = self::PROPERTY_VALUE_TABLE;
        $propTable = self::PROPERTY_TABLE;
        $subselect = $this->getSelect(['session' => $this->tableName])
                ->join(['term' => $this->tableName], 'term.parent = session.id', [], Select::JOIN_LEFT)
                ->join(['pv' => $pvTable], 'pv.id = term.property_value', ['id'])
                ->where(['session.property_value' => $session])
                ->columns([]);
        $select = $this->getSelect($pvTable)
                ->join(['mappedTerms' => $subselect], 'mappedTerms.id = property_value.id',[], Select::JOIN_LEFT)
                ->join(['prop' => $propTable], 'property_value.property = prop.id', [])
                ->where(['prop.name' => 'term', 'mappedTerms.id' => null]);
        return $this->select($select, $this->getPropertyValueEntity(), $this->getPropertyValueHydrator());
    }
    
    public function getRelPropertyValue($session) {
        $select = $this->getSelect()
                ->where(['property_value' => $session, 'parent' => null]);
        return $this->select($select)->current();
    }
}
