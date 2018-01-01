<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/EportalAdmin for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace EportalAdmin;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Stdlib\ArrayUtils;

class Module implements
AutoloaderProviderInterface,ViewHelperProviderInterface {

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
        $config = array();
        $configFiles = array(
             __DIR__ . '/config/module.config.php',
             __DIR__ . '/config/router.config.php'
        );
        foreach ($configFiles as $cf){
            $config = ArrayUtils::merge($config, include $cf);
        }
//        return include __DIR__ . '/config/module.config.php';
        return $config;
    }

    public function onBootstrap(MvcEvent $e) {
        // You may not need to do this if you're doing it elsewhere in your
        // application
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getViewHelperConfig() {
        return array(
            'invokables' => array(
                'renderResultFieldset' => 'EportalAdmin\Controller\Result\View\RenderUserResultFieldset'
            )
        );
    }

//    public function getRouteConfig() {
//         return include __DIR__ . '/config/router.config.php';
//    }
}
