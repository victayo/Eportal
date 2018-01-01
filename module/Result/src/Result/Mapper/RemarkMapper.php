<?php

namespace Result\Mapper;

/**
 *
 * @author imaleo
 */
class RemarkMapper extends AbstractResultDbMapper implements RemarkMapperInterface{
    
    public function getRemark($result){
        $select = $this->getSelect()
                ->where(array('result = ?' => $result));
        return $this->select($select);
    }
}
