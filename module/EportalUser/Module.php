<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/EportalUser for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace EportalUser;

use Zend\Form\Element\DateSelect;
use Zend\Form\Element\Select;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;
use ZfcUser\Authentication\Adapter\AdapterChain;
use ZfcUser\Form\Login;

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

    public function onBootstrap(MvcEvent $e) {
        $eventManager = $e->getApplication()->getEventManager();
        $sharedEventManager = $eventManager->getSharedManager();
        /**
         * @todo use $form->add($userfieldset) instead of adding each element inividually. DRY!!!
         */
        $sharedEventManager->attach('ZfcUser\Form\Register', 'init', function($e) {
            $form = $e->getTarget();
            $form->remove('passwordVerify')
                    ->remove('email')
                    ->remove('display_name');

            $form->add([
                        'name' => 'first_name',
                        'attributes' => [
                            'type' => 'text',
                            'required' => 'required'
                        ],
                        'options' => ['label' => 'First Name']
                    ])
                    ->add([
                        'name' => 'last_name',
                        'attributes' => [
                            'type' => 'text',
                            'required' => 'required'
                        ],
                        'options' => ['label' => 'Last Name']
                    ])
                    ->add([
                        'name' => 'middle_name',
                        'attributes' => [
                            'type' => 'text',
                            'required' => 'required'
                        ],
                        'options' => ['label' => 'Other Name(s)']
                    ])
                    ->add([
                        'name' => 'username',
                        'attributes' => [
                            'type' => 'text',
                            'required' => 'required'
                        ],
                        'options' => ['label' => 'Registration Number']
            ]);
            $gender = new Select('gender');
            $gender->setDisableInArrayValidator(true)
                    ->setAttribute('required', 'required')
                    ->setValueOptions(array(
                        1 => 'Male',
                        2 => 'Female'
                    ))
                    ->setEmptyOption('Select Gender')
                    ->setLabel('Gender');
            $dob = new DateSelect('dob'); //output format: Y-m-d
            $dob->setShouldCreateEmptyOption(true)
                    ->setMaxYear(date('Y') - 30)
                    ->setMinYear(date('Y') - 18)
                    ->setLabel('Date Of Birth')
                    ->setAttribute('required', 'required');
            $form->add($gender)
                    ->add($dob);
            $form->get('username')
                    ->setLabel('Registration Number');
        });
        $sharedEventManager->attach('ZfcUser\Form\RegisterFilter', 'init', function($e) {
            $filter = $e->getTarget();
            $filter->remove('email')
                    ->remove('password')
                    ->remove('passwordVerify');
            $filter->add(array(
                        'name' => 'first_name',
                        'required' => true,
                        'filters' => array(array('name' => 'StringTrim')),
                        'validators' => array(
                            array(
                                'name' => 'StringLength',
                                'options' => array(
                                    'min' => 3,
                                    'max' => 128,
                                ),
                            ),
                        ),
                    ))->add(array(
                        'name' => 'last_name',
                        'required' => true,
                        'filters' => array(array('name' => 'StringTrim')),
                        'validators' => array(
                            array(
                                'name' => 'StringLength',
                                'options' => array(
                                    'min' => 3,
                                    'max' => 128,
                                ),
                            ),
                        ),
                    ))
                    ->add(array(
                        'name' => 'middle_name',
                        'required' => true,
                        'filters' => array(array('name' => 'StringTrim')),
                        'validators' => array(
                            array(
                                'name' => 'StringLength',
                                'options' => array(
                                    'min' => 3,
                                    'max' => 128,
                                ),
                            ),
                        ),
            ));
        });

        //login form init
        $sl = $e->getApplication()->getServiceManager();
        $sharedEventManager->attach(Login::class, 'init', function($event) use ($sl) {
            $form = $event->getTarget();
            $fieldset = $sl->get('FormElementManager')->get('EportalProperty\Fieldset\EportalProperty');
            $fieldset->remove('school')
                    ->remove('class')
                    ->remove('department')
                    ->remove('subject');
            $form->add($fieldset);
        });

        $sharedEventManager->attach(AdapterChain::class, 'authenticate.success', function($event) {
            $request = $event->getParams()['request'];
            $container = new Container('eportal_login');
            $property = $request->getPost()->get('eportal_property');
            $container->session = $property['session'];
            $container->term = $property['term'];
        });
    }

}
