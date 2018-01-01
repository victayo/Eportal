<?php

namespace EportalSetting\Service;

/**
 *
 * @author imaleo
 */
interface EportalSettingServiceInterface {
    public function getHasSection();

    public function getClassOrder();

    public function getSectionOrder();

    public function getSchoolOrder();
    
    public function getActiveSession();

    public function getActiveTerm();

    public function setHasSection($has_section);

    public function setClassOrder($class_order);

    public function setSectionOrder($section_order);

    public function setSchoolOrder($school_order);
    
    public function setActiveSession($active_session);

    public function setActiveTerm($active_term);

    public function setMetaValue($meta, $value);
    
    public function getMetaValue($meta);
    
    public function sort($propertyValues, $property);
}
