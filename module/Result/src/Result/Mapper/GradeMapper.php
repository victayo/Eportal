<?php
namespace Result\Mapper;

/**
 *
 * @author imaleo
 *        
 */
class GradeMapper extends AbstractResultDbMapper implements GradeMapperInterface
{
	/* (non-PHPdoc)
     * @see \Result\Mapper\GradeMapperInterface::getGrade()
     */
    public function getGrade($grade)
    {
//         $op_1 = new \Zend\Db\Sql\Predicate\Operator('min',Operator::OPERATOR_GREATER_THAN_OR_EQUAL_TO, $grade);
//         $op_2 = new \Zend\Db\Sql\Predicate\Operator('max', Operator::OPERATOR_LESS_THAN_OR_EQUAL_TO, $grade);
        
//         $select = $this->getSelect()->where->addPredicates(array($op_1, $op_2));

        $select = $this->getSelect()->where
        ->lessThanOrEqualTo('min', $grade)
        ->greaterThanOrEqualTo('max', $grade);
        return $this->select($select)->current();
    }
    
    public function findById($id) {
        $select = $this->getSelect()
                ->where(['id = ?' => $id]);
        return $this->select($select)->current();
    }

}
