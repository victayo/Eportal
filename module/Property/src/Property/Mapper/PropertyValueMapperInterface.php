<?php

namespace Property\Mapper;

/**
 * Description of PropertyValueMapperInterface
 *
 * @author imaleo
 */
interface PropertyValueMapperInterface {

    public function findAll();

    public function findbyId($id);

    public function findByProperty($property);

    public function getId($property, $value);

    public function save($propertyValue);

    public function delete($where);
}
