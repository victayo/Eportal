<?php
namespace Property\Model;

/**
 *
 * @author imaleo
 *        
 */
class Property implements PropertyInterface
{

    private $id;
    private $name;
    
    public function __construct($id = null, $name = null){
        $this->id = $id;
        $this->name = $name;
    }
    /**
     * (non-PHPdoc)
     *
     * @see \Property\Model\PropertyInterface::getName()
     *
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Property\Model\PropertyInterface::setName()
     *
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Property\Model\PropertyInterface::setId()
     *
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Property\Model\PropertyInterface::getId()
     *
     */
    public function getId()
    {
        return $this->id;
    }
}

?>