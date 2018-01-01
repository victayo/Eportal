<?php

namespace Eportal\Form\View\Helper;

/**
 *
 * @author imaleo
 */
class FormInputNg extends \DluTwBootstrap\Form\View\Helper\FormInputTwb{
    protected function prepareAttributes(array $attributes){
        $ngAttributes = [];
        foreach($attributes as $key => $value){
            $attribute = strtolower($key);
            if('ng-' == substr($attribute, 0, 3)){
                $ngAttributes[$key] = $attributes[$key];
            }
        }
        $formattedAttributes = parent::prepareAttributes($attributes);
        return array_merge($formattedAttributes, $ngAttributes);
    }
}
