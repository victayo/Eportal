<?php

namespace Result\Service;

use Result\Mapper\GradeMapperInterface;
use Result\Service\GradeServiceInterface;

/**
 *
 * @author imaleo
 */
class GradeService implements GradeServiceInterface {
    /**
     *
     * @var GradeMapperInterface
     */
    protected $mapper;
    
    public function __construct(GradeMapperInterface $mapper) {
        $this->mapper = $mapper;
    }

    public function getGrade($score) {
        return $this->mapper->getGrade($score);
    }

    public function delete(\Result\Model\GradeInterface $grade) {
        $where = array('id = ?' =>$grade->getId());
        return $this->mapper->delete($where);
    }

    public function insert(\Result\Model\GradeInterface $grade) {
        return $this->mapper->insert($grade);
    }

    public function update(\Result\Model\GradeInterface $grade, $where = null) {
        if(!$where){
            $where = array('id = ?' => $grade->getId());
        }
        return $this->mapper->update($grade, $where);
    }

    public function getAll() {
        return $this->mapper->getAll();
    }

    public function findById($id) {
        return $this->mapper->findById($id);
    }

}
