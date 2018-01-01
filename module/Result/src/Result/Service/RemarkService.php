<?php
namespace Result\Service;

use Result\Mapper\RemarkMapperInterface;
use Result\Model\RemarkInterface;
use Result\Model\ResultInterface;
/**
 *
 * @author imaleo
 */
class RemarkService implements RemarkServiceInterface{
    protected $mapper;
    
    public function __construct(RemarkMapperInterface $mapper) {
        $this->mapper = $mapper;
    }
    
    public function delete(RemarkInterface $remark) {
        $where = array('result = ?' => $remark->getResult());
        return $this->mapper->delete($where);
    }

    public function getRemark(ResultInterface $result) {
        $res = $this->mapper->getRemark($result->getId());
        if($res->count() > 0){
            return $res->current();
        }
        return false;
    }

    public function insert(RemarkInterface $remark) {
        return $this->mapper->insert($remark);
    }

    public function update(RemarkInterface $remark, $where = null) {
        if(!$where){
            $where = array('result = ?' => $remark->getResult());
        }
        return $this->mapper->update($remark, $where);
    }

}
