<?php

namespace Result\Service;

use Result\Model\RemarkInterface;

/**
 *
 * @author imaleo
 */
interface RemarkServiceInterface {
    public function getRemark(\Result\Model\ResultInterface $result);
        
    public function insert(RemarkInterface $remark);
    
    public function update(RemarkInterface $remark, $where);
    
    public function delete(RemarkInterface $remark);
}
