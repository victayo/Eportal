<?php
namespace Result\Mapper;

use Result\Mapper\AbstractResultDbMapper;
use Result\Mapper\ResultScoreMapperInterface;

/**
 *
 * @author imaleo
 *        
 */
class ResultScoreMapper extends AbstractResultDbMapper implements ResultScoreMapperInterface
{
    protected $tableName = 'result_score';
    
    /**
     *
     * @see ResultScoreMapperInterface::findByResult()
     *
     */
    public function findByResult($result_id)
    {
        $select = $this->getSelect()->where(array(
            'result = ?' => $result_id
        ));
        return $this->select($select);
    }

    /**
     *
     * @see ResultScoreMapperInterface::findByAssessment()
     *
     */
    public function findByAssessment($assessment_id)
    {
        $select = $this->getSelect()->where(array(
            'assessment = ?' => $assessment_id
        ));
        return $this->select($select);
    }
    
    public function getResultScore($result_id, $assessment_id = null) {
        $select = $this->getSelect();
        $where = array('result = ?' => $result_id);
        if($assessment_id){
            $where['assessment = ?'] = $assessment_id;
        }
        $select->where($where);
        return $this->select($select);
    }
}
