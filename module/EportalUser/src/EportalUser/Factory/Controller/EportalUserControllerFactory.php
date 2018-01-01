<?php

namespace EportalUser\Factory\Controller;

use EportalUser\Controller\EportalUserController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author OKALA
 */
class EportalUserControllerFactory implements FactoryInterface{
    
    public function createService(ServiceLocatorInterface $controllerManager)
    {
        /* @var ControllerManager $controllerManager*/
        $serviceManager = $controllerManager->getServiceLocator();

        /* @var RedirectCallback $redirectCallback */
        $redirectCallback = $serviceManager->get('zfcuser_redirect_callback');

        /* @var EportalUserController $controller */
        $controller = new EportalUserController($redirectCallback);
        $controller->setServiceLocator($serviceManager);

        $controller->setChangeEmailForm($serviceManager->get('zfcuser_change_email_form'));
        $controller->setOptions($serviceManager->get('zfcuser_module_options'));
        $controller->setChangePasswordForm($serviceManager->get('zfcuser_change_password_form'));
        $controller->setLoginForm($serviceManager->get('zfcuser_login_form'));
        $controller->setRegisterForm($serviceManager->get('zfcuser_register_form'));
        $controller->setUserService($serviceManager->get('zfcuser_user_service'));
        return $controller;
    }
    
}
