<?php

namespace Result\Mapper;

/**
 *
 * @author imaleo
 */
interface ResultInterface {
    public function insert($entity);
    
    public function update($entity, $where);
    
    public function delete($where);
}
