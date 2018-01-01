<?php
namespace Result\Model;

/**
 *
 * @author imaleo
 *        
 */
class Grade implements GradeInterface
{

    protected $remark;

    protected $grade;

    protected $min;

    protected $max;
    
    protected $id;
    /**
     *
     * @see \Result\Model\GradeInterface::getRemark()
     *
     */
    public function getRemark()
    {
        return $this->remark;
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

        /**
     *
     * @see \Result\Model\GradeInterface::setGrade()
     *
     */
    public function setGrade($grade)
    {
        $this->grade = $grade;
        return $this;
    }

    /**
     *
     * @see \Result\Model\GradeInterface::setMin()
     *
     */
    public function setMin($min)
    {
        $this->min = $min;
        return $this;
    }

    /**
     *
     * @see \Result\Model\GradeInterface::getMin()
     *
     */
    public function getMin()
    {
        return $this->min;
    }

    /**
     *
     * @see \Result\Model\GradeInterface::getGrade()
     *
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     *
     * @see \Result\Model\GradeInterface::setMax()
     *
     */
    public function setMax($max)
    {
        $this->max = $max;
        return $this;
    }

    /**
     *
     * @see \Result\Model\GradeInterface::setRemark()
     *
     */
    public function setRemark($remark)
    {
        $this->remark = $remark;
        return $this;
    }

    /**
     *
     * @see \Result\Model\GradeInterface::getMax()
     *
     */
    public function getMax()
    {
        return $this->max;
    }
}

?>