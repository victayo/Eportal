<?php

namespace EportalSubject\Service;

use Property\Model\PropertyValueInterface;

/**
 *
 * @author OKALA
 */
interface EportalSubjectServiceInterface {

    public function saveSubject(PropertyValueInterface $subject);

    public function deleteSubject(PropertyValueInterface $subject);

    public function getSubject($subjectId);

    public function getSubjectProperty();
}
