<?php
namespace Result\Model;

/**
 *
 * @author imaleo
 *        
 */
class Result implements ResultInterface
{

    protected $id;

    protected $user;

    protected $subject;

    protected $session;

    protected $term;

    protected $date;

    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }

    /**
     *
     * @see \Result\Model\ResultInterface::setDate()
     *
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     *
     * @see \Result\Model\ResultInterface::getDate()
     *
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     *
     * @see \Result\Model\ResultInterface::getTerm()
     *
     */
    public function getTerm()
    {
        return $this->term;
    }

    /**
     *
     * @see \Result\Model\ResultInterface::setTerm()
     *
     */
    public function setTerm($term)
    {
        $this->term = $term;
        return $this;
    }

    /**
     *
     * @see \Result\Model\ResultInterface::setSession()
     *
     */
    public function setSession($session)
    {
        $this->session = $session;
        return $this;
    }

    /**
     *
     * @see \Result\Model\ResultInterface::getSession()
     *
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     *
     * @see \Result\Model\ResultInterface::setId()
     *
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     *
     * @see \Result\Model\ResultInterface::getId()
     *
     */
    public function getId()
    {
        return $this->id;
    }

    public function getSubject() {
        return $this->subject;
    }

    public function setSubject($subject) {
        $this->subject = $subject;
        return $this;
    }

}
