<?php

namespace EportalSetting\Form;

use Eportal\Form\EportalForm;

/**
 *
 * @author imaleo
 */
class EportalSettingForm extends EportalForm {

    public function __construct($name = null) {
        parent::__construct($name);
        $this->add([
            'name' => 'setting',
            'type' => 'EportalSetting\Form\EportalSettingFieldset',
            'options' => [
                'use_as_base_fieldset' => true
            ]
        ]);
    }
}
