<?php

namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Users\Form\LoginForm;
use Users\Form\LoginFilter;
use Users\Model\User;
use Users\Model\UserTable;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;


class LoginController extends AbstractActionController {

	private $authservice;

    public function indexAction() {
        //$form = new LoginForm();
    
        $form = $this->getServiceLocator()->get('LoginForm');
        return new ViewModel(array('form' => $form));
    }

// Class definition
/*    public function getAuthService() {
        if (!$this->authservice) {
           // $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
           // $dbTableAuthAdapter = new DbTableAuthAdapter($dbAdapter, 'users', 'users_email', 'users_password', 'MD5(?)');
           // $authService = new AuthenticationService();
          //  $authService->setAdapter($dbTableAuthAdapter);
            $authService =$this->getServiceLocator()->get('AuthService');
            $this->authservice = $authService;
        }
       //var_dump($this->authservice->toArray());exit;
        return $this->authservice;
    }*/

    public function processAction() {
        if (!$this->authservice) {
             $this->authservice=$this->getServiceLocator()->get('AuthService');
        }
        $this->authservice->getAdapter()->setIdentity($this->request->getPost('users_email'))->setCredential($this->request->getPost('users_password'));
        $result = $this->authservice->authenticate();
        if ($result->isValid()) {
            $this->authservice->getStorage()->write($this->request->getPost('users_email'));
            return $this->redirect()->toRoute("user/default", array(
                        'controller' => 'login',
                        'action' => 'confirm'
            ));
        };
        return $this->redirect()->toRoute("user/default", array(
                        'controller' => 'login',
                        'action' => 'index',
                      
            ));
    }
        

    public function confirmAction(){
            if (!$this->authservice) {
                 $this->authservice=$this->getServiceLocator()->get('AuthService');
            }
            $users_email = $this->authservice->getStorage()->read();
            $viewModel = new ViewModel(array(
                'users_email' => $users_email
            ));
            return $viewModel;
        }

}