<?php

namespace EportalSetting\Service;

use EportalSetting\Mapper\EportalSettingMapper;
use EportalSetting\Model\EportalSetting;

/**
 *
 * @author imaleo
 */
class EportalSettingService implements EportalSettingServiceInterface {

    protected $mapper;

    public function __construct(EportalSettingMapper $mapper) {
        $this->mapper = $mapper;
    }

    /**
     * 
     * @return boolean
     */
    public function getHasSection() {
        $setting = $this->mapper->getMetaValue('has_section');
        return boolval($setting->getValue());
    }

    /**
     * 
     * @return PropertyValueOrderSet
     */
    public function getSchoolOrder() {
        $setting = $this->mapper->getMetaValue('school_order');
        return unserialize($setting->getValue());
    }

    /**
     * 
     * @return PropertyValueOrderSet
     */
    public function getClassOrder() {
        $setting = $this->mapper->getMetaValue('class_order');
        return unserialize($setting->getValue());
    }

    /**
     * 
     * @return PropertyValueOrderSet
     */
    public function getSectionOrder() {
        $setting = $this->mapper->getMetaValue('section_order');
        return unserialize($setting->getValue());
    }

    public function getActiveTerm() {
        $setting = $this->mapper->getMetaValue('active_term');
        return $setting->getValue();
    }

    public function getActiveSession() {
        $setting = $this->mapper->getMetaValue('active_session');
        return $setting->getValue();
    }

    public function setHasSection($has_section) {
        return $this->setMetaValue('has_section', $has_section);
    }

    public function setSchoolOrder($school_order) {
        return $this->setMetaValue('school_order', $school_order);
    }

    public function setClassOrder($class_order) {
        return $this->setMetaValue('class_order', $class_order);
    }

    public function setSectionOrder($section_order) {
        return $this->setMetaValue('section_order', $section_order);
    }

    public function setActiveSession($active_session) {
        return $this->setMetaValue('active_session', $active_session);
    }

    public function setActiveTerm($active_term) {
        return $this->setMetaValue('active_term', $active_term);
    }

    public function setMetaValue($meta, $value) {
        $setting = new EportalSetting($meta, $value);
        $this->mapper->save($setting);
        return $this;
    }

    public function getMetaValue($meta) {
        return $this->mapper->getMetaValue($meta);
    }

    public function sort($propertyValues, $property) {
        $pvOrder = $this->getMetaValue(strtolower($property) . '_order');
        if ($pvOrder) {
            $pvoSet = unserialize($pvOrder);
            return $pvoSet->getSortedPropertyValues($propertyValues);
        }
        /**
         * @todo The default sort for $propertyValues should be alphabetic
         */
        return $propertyValues;
    }

}
