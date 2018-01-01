<?php
namespace Result\Mapper;

/**
 *
 * @author imaleo
 *        
 */
class AssessmentMapper extends AbstractResultDbMapper implements AssessmentMapperInterface
{
    protected $tableName = 'assessment';
    
    public function getAll() {
        return $this->select($this->getSelect());
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Result\Mapper\AssessmentMapperInterface::findById()
     *
     */
    public function findById($assessment_id)
    {
        $select = $this->getSelect()->where(array(
            'id = ?' => $assessment_id
        ));
        return $this->select($select)->current();
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Result\Mapper\AssessmentMapperInterface::findBySession()
     *
     */
    private function findBySession($session_id)
    {
        $select = $this->getSelect()->where(array(
            'session = ?' => $session_id
        ));
        return $this->select($select);
    }
    
    /**
     * (non-PHPdoc)
     *
     * @see \Result\Mapper\AssessmentMapperInterface::findByTerm()
     *
     */
    private function findByTerm($term_id)
    {
        $select = $this->getSelect()->where(array(
            'term = ?' => $term_id
        ));
        return $this->select($select);
    }
}

?>