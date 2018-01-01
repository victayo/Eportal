<?php

namespace Result\Model;

/**
 *
 * @author imaleo
 */
class Remark implements RemarkInterface{
    protected $result;
    protected $remark;
    
    public function getResult() {
        return $this->result;
    }

    public function getRemark() {
        return $this->remark;
    }

    public function setResult($result) {
        $this->result = $result;
        return $this;
    }

    public function setRemark($remark) {
        $this->remark = $remark;
        return $this;
    }
}
