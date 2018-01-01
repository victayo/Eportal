<?php
namespace EportalUser\Controller;

use Zend\Session\Container;
use ZfcUser\Controller\UserController;

/**
 *
 * @author imaleo
 *        
 */
class EportalUserController extends UserController
{
    public function loginAction() {
        if ($this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute($this->getOptions()->getLoginRedirectRoute());
        }
        $request = $this->getRequest();
        $form = $this->getLoginForm();
        if($request->isPost()){
            $post = $request->getPost();
            $form->setData($post);
            if($form->isValid()){
                $container = new Container('eportal_login');
                $container->session = $post['session'];
                $container->term = $post['term'];
            }
        }
        return parent::loginAction();
    }
}
