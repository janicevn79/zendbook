<?php

namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Users\Model\UserTable;
use Users\Model\User;
//use Users\Model\User;
/*use Users\Form\RegisterForm;
use Users\Form\RegisterFilter;
*/

class UserManagerController extends AbstractActionController {

	public function indexAction() {
        $userTable= $this->getServiceLocator()->get('UserTable');
        //var_dump($userTable);exit;
        $viewModel = new ViewModel(array('users' => $userTable->fetchAll()));
        return $viewModel;
    }

    public function editAction() {
    	$id=$this->params()->fromRoute('id');
    	$userTable= $this->getServiceLocator()->get('UserTable');
    	$user=$userTable->getUser($id);
    	//var_dump($user);exit;
    	$form = $this->getServiceLocator()->get('UserEditForm');
        $form->bind($user); 
        $viewModel = new ViewModel(array(
        	'form' => $form,
        	'user_id' => $id,
        	));
        return $viewModel;
    }

    public function addAction() {
        //var_dump($user);exit;
        $form = $this->getServiceLocator()->get('UserAdminForm');
        $viewModel = new ViewModel(array(
            'form' => $form,
            ));
        return $viewModel;
    }

    public function deleteAction() {
    	$id=$this->params()->fromRoute('id');
    	$this->getServiceLocator()->get('UserTable')->deleteUser($id);
    	return $this->redirect()->toRoute('user-manager/default' ,array( 'controller' => 'user-manager','action' => 'index'));
	}

    public function processAction() {
    	if (!$this->request->isPost()) {
            return $this->redirect()->toRoute(NULL ,array( 'controller' => 'user-manager','action' => 'index'));
        }
		// Get User ID from POST
		$post = $this->request->getPost();
		$id=$this->params()->fromRoute('id');
        if ($id){
    		$userTable = $this->getServiceLocator()->get('UserTable');
    		// Load User entity
    		$userData = $userTable->getUser($id);
    		// Bind User entity to Form
    		$form = $this->getServiceLocator()->get('UserEditForm');
    		//ovde postavlja stare podatke user
    		$form->bind($userData);
    		//ovde zamazuje stare tj.difoltne koje smopodeili u prethodnom korakuiz post
    		//var_dump($post->users_password);exit;
    		$form->setData($post);
            
        }

		//unset($post->users_password);
		// Save user
		$user = new User();
        $user->exchangeArray($post);
        if ($id) $user->password=$post->users_password;
		$this->getServiceLocator()->get('UserTable')->saveUser($user);
		return $this->redirect()->toRoute('user-manager/default' ,array( 'controller' => 'user-manager','action' => 'index'));

    }

}
