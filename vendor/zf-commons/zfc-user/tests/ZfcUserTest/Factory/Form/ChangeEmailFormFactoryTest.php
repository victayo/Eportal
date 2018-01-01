<?php
namespace ZfcUserTest\Factory\Form;

use Zend\Form\FormElementManager;
use Zend\ServiceManager\ServiceManager;
use ZfcUser\Factory\Form\ChangeEmail as ChangeEmailFactory;
use ZfcUser\Options\ModuleOptions;
use ZfcUser\Mapper\User as UserMapper;

class ChangeEmailFormFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testFactory()
    {
        $serviceManager = new ServiceManager;
        $serviceManager->setService('zfcuser_module_options', new ModuleOptions);
        $serviceManager->setService('zfcuser_user_mapper', new UserMapper);

        $formElementManager = new FormElementManager();
        $formElementManager->setServiceLocator($serviceManager);
        $serviceManager->setService('FormElementManager', $formElementManager);

        $factory = new ChangeEmailFactory();

        $this->assertInstanceOf('ZfcUser\Form\ChangeEmail', $factory->createService($formElementManager));
    }
}
