<?php
namespace Result\Model;

/**
 *
 * @author imaleo
 *        
 */
class Assessment implements AssessmentInterface
{

    protected $id;

    protected $maxScore;

    protected $includeInCumulative;

    protected $isExam;

    protected $name;
    
    /**
     *
     * @see \Result\Model\AssessmentInterface::setIncludeInCumulative()
     *
     */
    public function setIncludeInCumulative($includeInCumulative)
    {
        $this->includeInCumulative = $includeInCumulative;
        return $this;
    }

    /**
     *
     * @see \Result\Model\AssessmentInterface::getMaxScore()
     *
     */
    public function getMaxScore()
    {
        return $this->maxScore;
    }

    /**
     *
     * @see \Result\Model\AssessmentInterface::setMaxScore()
     *
     */
    public function setMaxScore($maxScore)
    {
        $this->maxScore = $maxScore;
        return $this;
    }

    /**
     *
     * @see \Result\Model\AssessmentInterface::getIsExam()
     *
     */
    public function getIsExam()
    {
        return $this->isExam;
    }

    /**
     *
     * @see \Result\Model\AssessmentInterface::getName()
     *
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *
     * @see \Result\Model\AssessmentInterface::setIsExam()
     *
     */
    public function setIsExam($exam)
    {
        $this->isExam = $exam;
        return $this;
    }

    /**
     *
     * @see \Result\Model\AssessmentInterface::setName()
     *
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     *
     * @see \Result\Model\AssessmentInterface::getIncludeInCumulative()
     *
     */
    public function getIncludeInCumulative()
    {
        return $this->includeInCumulative;
    }

    /**
     *
     * @see \Result\Model\AssessmentInterface::setId()
     *
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     *
     * @see \Result\Model\AssessmentInterface::getId()
     *
     */
    public function getId()
    {
        return $this->id;
    }
}
