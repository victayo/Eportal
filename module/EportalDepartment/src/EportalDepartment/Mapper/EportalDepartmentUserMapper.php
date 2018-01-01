<?php



namespace EportalDepartment\Mapper;

use EportalDepartment\Mapper\EportalDepartmentMapperInterface;
use EportalDepartment\Mapper\EportalDepartmentUserMapperInterface;
use EportalProperty\Mapper\AbstractEportalPropertyUserMapper;
use Zend\Db\Sql\Select;
/**
 * @author OKALA
 */
class EportalDepartmentUserMapper extends AbstractEportalPropertyUserMapper implements EportalDepartmentUserMapperInterface {

    /**
     *
     * @var EportalDepartmentMapperInterface
     */
    protected $eportalDepartmentMapper;

    public function __construct(EportalDepartmentMapperInterface $eportalDepartmentMapper) {
        $this->eportalDepartmentMapper = $eportalDepartmentMapper;
    }

    public function addUser($user, $session, $term, $school, $class, $department, $addSubjects = true) {
        $rpv = $this->eportalDepartmentMapper->getRelPropertyValue($school, $class, $department);
        $saved = $this->addUserHelper($user, $session, $term, $rpv);
        if(!$saved){
            return false;
        }
        $ust = $saved['ust'];
        if ($addSubjects) {//save department subjects
            $subjects = $this->getSubjects($school, $class, $department);
            foreach ($subjects as $subject) {
                $subEnt = $this->getEntityPrototype()
                        ->setRelPropertyValue($subject->getId())
                        ->setUserSessionTerm($ust->getId());
                $this->save($subEnt);
            }
        }
        return true;
    }

    public function getUsers($session, $term, $school, $class, $department, $role = null) {
        $rpv = $this->eportalDepartmentMapper->getRelPropertyValue($school, $class, $department);
        return $this->getUsersHelper($session, $term, $rpv, $role);
    }

    public function getUnregisteredUsers($session, $term, $school, $class, $department, $role = null) {
        $rpv = $this->eportalDepartmentMapper->getRelPropertyValue($school, $class, $department);
        if(!$rpv){
            return false;
        }
        return $this->getUnregisteredUsersHelper($session, $term, $rpv, $role);
    }

    public function removeUser($user, $session, $term, $school, $class, $department) {
        $rpv = $this->eportalDepartmentMapper->getRelPropertyValue($school, $class, $department);
        return $this->removeUserHelper($user, $session, $term, $rpv);
    }

    protected function getSubjects($school, $class, $department) {
        $tableName = self::REL_PROPERTY_VALUE_TABLE;
        $select = $this->getSelect(['school' => $tableName])
                ->join(['class' => $tableName], 'class.parent = school.id', [], Select::JOIN_LEFT)
                ->join(['department' => $tableName], 'department.parent = class.id', [], Select::JOIN_LEFT)
                ->join(['subject' => $tableName], 'subject.parent = department.id', ['id'], Select::JOIN_LEFT)
                ->where([
                    'school.property_value' => $school,
                    'class.property_value' => $class,
                    'department.property_value' => $department,
                ])
                ->columns([]);
        return $this->select($select, $this->eportalDepartmentMapper->getEntityPrototype(), $this->eportalDepartmentMapper->getHydrator());
    }

}
