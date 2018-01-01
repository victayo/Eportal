<?php


namespace PropertyTest\Mapper\Model;

/**
 * Description of JpvTestModel
 *
 * @author imaleo
 */
class JpvTestModel {
    private $id;
    private $fpv;
    private $spv;
    /**
     */
    function __construct($id = null, $fpv = null, $spv = null)
    {
        $this->id = $id;
        $this->fpv = $fpv;
        $this->spv = $spv;
    }

    public function getFirstPropertyValue()
    {
        return $this->fpv;
    }

     public function setSecondPropertyValue($spv)
    {
        $this->spv = $spv;
        return $this;
    }

    public function setFirstPropertyValue($fpv)
    {
        $this->fpv = $fpv;
        return $this;
    }

    public function getSecondPropertyValue()
    {
        return $this->spv;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }
}
