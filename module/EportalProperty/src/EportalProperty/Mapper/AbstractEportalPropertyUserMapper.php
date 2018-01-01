<?php

namespace EportalProperty\Mapper;

use EportalUser\Mapper\UserSessionTermMapper;
use EportalUser\Model\EportalUserInterface;
use Property\Mapper\AbstractPropertyDbMapper;
use Property\Mapper\Hydrator\PropertyValueHydrator;
use Property\Model\PropertyValueInterface;
use Zend\Db\Sql\Predicate\NotIn;
use ZfcUser\Mapper\UserHydrator;

/**
 * @author OKALA
 */
abstract class AbstractEportalPropertyUserMapper extends AbstractPropertyDbMapper {

    const USER_SESSION_TERM_TABLE = 'user_session_term';
    const USER_REL_PROPERTY_VALUE_TABLE = 'user_rel_property_value';
    const USER_TABLE = 'eportal_user';
    const ROLE_TABLE = 'user_role';
    const ROLE_LINKER_TABLE = 'user_role_linker';
    
    const EPORTAL_SESSION = 'session';
    const EPORTAL_TERM = 'term';
    const EPORTAL_SCHOOL = 'school';
    const EPORTAL_CLASS = 'class';
    const EPORTAL_DEPARTMENT = 'department';
    const EPORTAL_SUBJECT = 'subject';
    /**
     *
     * @var EportalUserInterface
     */
    protected $userEntity;

    /**
     *
     * @var UserHydrator
     */
    protected $userHydrator;

    /**
     *
     * @var PropertyValueInterface
     */
    protected $propertyValueEntity;

    /**
     *
     * @var PropertyValueHydrator
     */
    protected $propertyValueHydrator;

    /**
     *
     * @var UserSessionTermMapper
     */
    protected $userSessionTermMapper;

    public function getUserEntity() {
        return $this->userEntity;
    }

    public function getUserHydrator() {
        return $this->userHydrator;
    }

    public function setUserEntity(EportalUserInterface $userEntity) {
        $this->userEntity = $userEntity;
        return $this;
    }

    public function setUserHydrator(UserHydrator $userHydrator) {
        $this->userHydrator = $userHydrator;
        return $this;
    }

    public function getUserSessionTermMapper() {
        return $this->userSessionTermMapper;
    }

    public function setUserSessionTermMapper(UserSessionTermMapper $userSessionTermMapper) {
        $this->userSessionTermMapper = $userSessionTermMapper;
        return $this;
    }

    protected function getUsersHelper($session, $term, $rpv, $role) {
        if (!$rpv) {
            return false;
        }
        $select = $this->getSelect()
                ->join(['ust' => self::USER_SESSION_TERM_TABLE], 'ust.id = user_session_term', [])
                ->join(['user' => self::USER_TABLE], 'user.user_id = ust.user');
        $where = [
            'ust.session' => $session,
            'ust.term' => $term,
            'rel_property_value' => $rpv->getId(),
        ];
        if ($role) {
            $where['role.role_id'] = $role;
            $select->join(['user_role' => self::ROLE_LINKER_TABLE], 'user_role.user_id = ust.user', [])
                    ->join(['role' => self::ROLE_TABLE], 'role.id = user_role.role_id', []);
        }
        $select->where($where)->columns([]);
        return $this->select($select, $this->getUserEntity(), $this->getUserHydrator());
    }

    protected function addUserHelper($user, $session, $term, $rpv) {
        $ust = $this->getUserSessionTermMapper()->getUserSessionTerm($user, $session, $term);
        if (!$ust || !$rpv) {
            return false;
        }
        $entity = $this->getEntityPrototype()
                ->setRelPropertyValue($rpv->getId())
                ->setUserSessionTerm($ust->getId());
        $this->save($entity);
        return ['entity' => $entity, 'ust' => $ust];
    }

    protected function removeUserHelper($user, $session, $term, $rpv) {
        $ust = $this->getUserSessionTermMapper()->getUserSessionTerm($user, $session, $term);
        if (!$ust || !$rpv) {
            return false;
        }
        $this->delete(['user_session_term' => $ust->getId(), 'rel_property_value' => $rpv->getId()]);
        return true;
    }
    
    
    public function getUnregisteredUsersHelper($session, $term, $rpv, $role) {
        $where = [
            'ust.session' => $session,
            'ust.term' => $term,
        ];
        $select = $this->getSelect(['ust'=>self::USER_SESSION_TERM_TABLE])
                ->join(['users'=>  self::USER_TABLE], 'ust.user = users.user_id');
        if ($role) {
            $where['role.role_id'] = $role;
            $select->join(['user_role' => self::ROLE_LINKER_TABLE], 'user_role.user_id = ust.user', [])
                    ->join(['role' => self::ROLE_TABLE], 'role.id = user_role.role_id', []);
        }
        $where[] = new NotIn('users.user_id', $this->getSubUsers($session, $term, $rpv, $role));
        $select->where($where)
                ->columns([]);
        return $this->select($select, $this->getUserEntity(), $this->getUserHydrator());
    }

    private function getSubUsers($session, $term, $rpv, $role = null){
        $select = $this->getSelect()
                ->join(['ust' => self::USER_SESSION_TERM_TABLE], 'ust.id = user_session_term', [])
                ->join(['user' => self::USER_TABLE], 'user.user_id = ust.user', ['user_id']);
        $where = [
            'ust.session' => $session,
            'ust.term' => $term,
            'rel_property_value' => $rpv->getId(),
        ];
        if ($role) {
            $where['role.role_id'] = $role;
            $select->join(['user_role' => self::ROLE_LINKER_TABLE], 'user_role.user_id = ust.user', [])
                    ->join(['role' => self::ROLE_TABLE], 'role.id = user_role.role_id', []);
        }
        $select->where($where)
                ->columns([]);
        return $select;
    }
    
    protected function getUserProperty($user, $session, $term, $property) {
        $select = $this->getSelect(['ust' =>self::USER_SESSION_TERM_TABLE])
                ->join(['urpv' => self::USER_REL_PROPERTY_VALUE_TABLE], 'urpv.user_session_term = ust.id', [])
                ->join(['rpv' => self::REL_PROPERTY_VALUE_TABLE], 'rpv.id = urpv.rel_property_value', [])
                ->join(['pv' => self::PROPERTY_VALUE_TABLE], 'pv.id = rpv.property_value')
                ->join(['prop' => self::PROPERTY_TABLE], 'prop.id = pv.property', [])
                ->where([
                    'ust.user' => $user,
                    'ust.session' => $session,
                    'ust.term' => $term,
                    'prop.name' => $property
                ])
                ->columns([])->quantifier('DISTINCT');
        return $this->select($select, $this->getPropertyValueEntity(), $this->getPropertyValueHydrator());
    }
}
