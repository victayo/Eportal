<?php
namespace Result\Model;

/**
 *
 * @author imaleo
 *        
 */
class ResultScore implements ResultScoreInterface
{
    protected $result;
    protected $assessment;
    protected $score;

    /**
     *
     * @see ResultScoreInterface::setResult()
     *
     */
    public function setResult($result)
    {
        $this->result = $result;
        return $this;
    }

    /**
     *
     * @see ResultScoreInterface::getAssessment()
     *
     */
    public function getAssessment()
    {
        return $this->assessment;
    }

    /**
     *
     * @see ResultScoreInterface::getScore()
     *
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     *
     * @see ResultScoreInterface::setScore()
     *
     */
    public function setScore($score)
    {
        $this->score = $score;
        return $this;
    }

    /**
     *
     * @see ResultScoreInterface::getResult()
     *
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     *
     * @see ResultScoreInterface::setAssessment()
     *
     */
    public function setAssessment($assessment)
    {
        $this->assessment = $assessment;
        return $this;
    }
}

?>