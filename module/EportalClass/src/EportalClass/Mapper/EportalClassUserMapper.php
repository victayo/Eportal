<?php

namespace EportalClass\Mapper;

use EportalProperty\Mapper\AbstractEportalPropertyUserMapper;
use Zend\Db\Sql\Select;

/**
 * @author OKALA
 */
class EportalClassUserMapper extends AbstractEportalPropertyUserMapper implements EportalClassUserMapperInterface {

    /**
     *
     * @var EportalClassMapperInterface
     */
    protected $eportalClassMapper;

    public function __construct(EportalClassMapperInterface $eportalClassMapper) {
        $this->eportalClassMapper = $eportalClassMapper;
    }

    public function addUser($user, $session, $term, $school, $class, $addSubjects = true) {
        $rpv = $this->eportalClassMapper->getRelPropertyValue($school, $class);
        $added = $this->addUserHelper($user, $session, $term, $rpv);
        if(!$added){
            return false;
        }
        //add user to class subjects
        if ($addSubjects) {
            $subjects = $this->getSubjects($school, $class);
            foreach ($subjects as $subject) {
                $subEntity = $this->getEntityPrototype()
                        ->setUserSessionTerm($added['ust']->getId())
                        ->setRelPropertyValue($subject->getId());
                $this->save($subEntity);
            }
        }
        return true;
    }

    public function getUsers($session, $term, $school, $class, $role = null) {
        $rpv = $this->eportalClassMapper->getRelPropertyValue($school, $class);
        return $this->getUsersHelper($session, $term, $rpv, $role);
    }

    public function removeUser($user, $session, $term, $school, $class) {
        $rpv = $this->eportalClassMapper->getRelPropertyValue($school, $class);
        return $this->removeUserHelper($user, $session, $term, $rpv);
    }

    public function getUnregisteredUsers($session, $term, $school, $class, $role) {
        $rpv = $this->eportalClassMapper->getRelPropertyValue($school, $class);
        if (!$rpv) {
            return false;
        }
        return $this->getUnregisteredUsersHelper($session, $term, $rpv, $role);
    }
    
    
    protected function getSubjects($school, $class) {
        $select = $this->getSelect(['school' => self::REL_PROPERTY_VALUE_TABLE])
                ->join(['class' => self::REL_PROPERTY_VALUE_TABLE], 'class.parent = school.id', [], Select::JOIN_LEFT)
                ->join(['subject' => self::REL_PROPERTY_VALUE_TABLE], 'subject.parent = class.id', ['id'], Select::JOIN_LEFT)
                ->join(['pv_table' =>self::PROPERTY_VALUE_TABLE], 'pv_table.id = subject.property_value', [])
                ->join(['prop' => self::PROPERTY_TABLE], 'prop.id = pv_table.property', [])
                ->where(['school.property_value' => $school, 'class.property_value' => $class, 'prop.name' => 'subject'])
                ->columns([]);
        return $this->select($select, $this->eportalClassMapper->getEntityPrototype(false), $this->eportalClassMapper->getHydrator());
    }

}
