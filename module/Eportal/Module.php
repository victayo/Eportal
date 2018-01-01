<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Eportal for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Eportal;

use Eportal\Form\View\Helper\FormInputNg;
use Eportal\Form\View\Helper\FormNg;
use Eportal\Form\View\Helper\FormRowNg;
use Eportal\Form\View\Helper\FormSelectNg;
use Eportal\Form\View\Helper\FormSubmitNg;
use Eportal\Form\View\Helper\FormTextNg;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Session\Config\SessionConfig;
use Zend\Session\Container;
use Zend\Session\SessionManager;

class Module implements AutoloaderProviderInterface {

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    // if we're in a namespace deeper than one level we need to fix the \ in the path
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/', __NAMESPACE__),
                ),
            ),
        );
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * 
     * @param MvcEvent $e
     */
    public function onBootstrap(MvcEvent $e) {
        // You may not need to do this if you're doing it elsewhere in your
        // application
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $this->initSession([
            'remember_me_seconds' => 180,
            'use_cookies' => true,
            'cookie_httponly' => true
        ]);
    }

    public function getViewHelperConfig() {
        return array(
            'factories' => array(
                'formselectng' => function($sm) {
                    $sl = $sm->getServiceLocator();
                    $genUtil = $sl->get('dlu_twb_gen_util');
                    $formUtil = $sl->get('dlu_twb_form_util');
                    $instance = new FormSelectNg($genUtil, $formUtil);
                    return $instance;
                },
                'formsubmitng' => function($sm) {
                    $sl = $sm->getServiceLocator();
                    $genUtil = $sl->get('dlu_twb_gen_util');
                    $formUtil = $sl->get('dlu_twb_form_util');
                    return new FormSubmitNg($genUtil, $formUtil);
                },
                'formng' => function($sm) {
                    $sl = $sm->getServiceLocator();
                    $genUtil = $sl->get('dlu_twb_gen_util');
                    $formUtil = $sl->get('dlu_twb_form_util');
                    return new FormNg($genUtil, $formUtil);
                },
                'formrowng' => function($sm) {
                    $sl = $sm->getServiceLocator();
                    $genUtil = $sl->get('dlu_twb_gen_util');
                    $formUtil = $sl->get('dlu_twb_form_util');
                    return new FormRowNg($genUtil, $formUtil);
                },
                'forminputng' => function($sm) {
                    $sl = $sm->getServiceLocator();
//                    $genUtil = $sl->get('dlu_twb_gen_util');
                    $formUtil = $sl->get('dlu_twb_form_util');
                    return new FormInputNg($formUtil);
                },
                'formtextng' => function($sm) {
                    $sl = $sm->getServiceLocator();
                    $genUtil = $sl->get('dlu_twb_gen_util');
                    $formUtil = $sl->get('dlu_twb_form_util');
                    return new FormTextNg($genUtil, $formUtil);
                },
            )
        );
    }

    protected function initSession($config) {
        $sessionConfig = new SessionConfig();
        $sessionConfig->setOptions($config);
        $sessionManager = new SessionManager($sessionConfig);
        $sessionManager->start();
        Container::setDefaultManager($sessionManager);
    }
}
