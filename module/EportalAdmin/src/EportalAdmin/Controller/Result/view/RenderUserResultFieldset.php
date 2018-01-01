<?php

namespace EportalAdmin\Controller\Result\View;

use Exception;
use Result\Model\AssessmentInterface;
use Zend\View\Helper\AbstractHelper;

/**
 *
 * @author imaleo
 */
class RenderUserResultFieldset extends AbstractHelper{
    
    public function __invoke($fieldset, $assessments, $before = "<td>", $after = "</td>") {
        $html = '';
        foreach($assessments as $assessment){
            if(is_string($assessment)){
                $elementName = $assessment;
            }elseif($assessment instanceof AssessmentInterface){
                $elementName = $assessment->getName();
            }else{
                throw new Exception('Invalid argument for $assessments');
            }
            $element = $fieldset->get($elementName);
            $html .= $before.$this->getView()->formRow($element).$after.PHP_EOL;
        }
        return $html;
    }
}
