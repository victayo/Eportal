<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/EportalAdmin for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace EportalAdmin\Controller;

use EportalSetting\Service\EportalSettingServiceInterface;
use EportalUser\Service\EportalUserServiceInterface;
use Zend\Mvc\Controller\AbstractActionController;

class EportalAdminController extends AbstractActionController {

    /**
     *
     * @var EportalUserServiceInterface
     */
    protected $eportalUserService;

    /**
     *
     * @var EportalSettingServiceInterface
     */
    protected $settingService;
    public function indexAction() {
        $userService = $this->getEportalUserService();
        $settingService = $this->getSettingService();
        $property = $this->Property();
        $propertyValue = $this->PropertyValue();
        
        return [
            'total_students' => [
                'total' => $userService->getTotalUser('student'),
                'male' => $userService->getTotalGender('male', 'student'),
                'female' => $userService->getTotalGender('female', 'student')
            ],
            'total_teachers' => [
                'total' => $userService->getTotalUser('teacher'),
                'male' => $userService->getTotalGender('male', 'teacher'),
                'female' => $userService->getTotalGender('female', 'teacher'),
            ],
            'schools' => $propertyValue->getPropertyCount($property->findByName('school')),
            'classes' => $propertyValue->getPropertyCount($property->findByName('class')),
            'departments' => $propertyValue->getPropertyCount($property->findByName('department')),
            'subjects' => $propertyValue->getPropertyCount($property->findByName('subject')),
            'session' => $propertyValue->findById($settingService->getActiveSession()),
            'term' => $propertyValue->findById($settingService->getActiveTerm())
        ];
    }

    public function getEportalUserService() {
        if (!$this->eportalUserService) {
            $this->eportalUserService = $this->getServiceLocator()->get('EportalUser\Service\EportalUser');
        }
        return $this->eportalUserService;
    }

    public function setEportalUserService(EportalUserServiceInterface $eportalUserService) {
        $this->eportalUserService = $eportalUserService;
        return $this;
    }

    public function getSettingService() {
        if(!$this->settingService){
            $this->settingService = $this->getServiceLocator()->get('EportalSetting\Service\EportalSetting');
        }
        return $this->settingService;
    }

    public function setSettingService(EportalSettingServiceInterface $settingService) {
        $this->settingService = $settingService;
        return $this;
    }


}
