<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\TableGateway\TableGateway;

use Users\Form\UserForm;
use Users\Form\UserFilter;


class IndexController extends AbstractActionController
{
    private $usersTable;

    public function indexAction()
    {

        return new ViewModel(array('rowset' => $this->getUsersTable()->select()));
    }
    public function createAction()
    {
        $form= new UserForm();
        $request= $this->getRequest();
        if ($request->isPost())
        {
            $form->setInputFilter(new UserFilter());
            $form->setData($request->getPost());
            if ($form->isValid()){
                $data= $form->getData();
                //mora da se koni polje submit jer ga nema u nasoj tablici
                unset($data['submit']);
                $this->getUsersTable()->insert($data);
                return $this->redirect()->toRoute('index/default',array('controler'=>'index','action'=>'index'));
            }
        }
        return new ViewModel(array('form'=>$form));
    }
    public function updateAction()
    {   
        $id=$this->params('id');
        if (empty($id))  return $this->redirect()->toRoute('user/default',array('controler'=>'index','action'=>'index'));
        $form= new UserForm();

        $request= $this->getRequest();
        if ($request->isPost())
        {
            $form->setInputFilter(new UserFilter());
            $form->setData($request->getPost());
            if ($form->isValid()){
                $data= $form->getData();
                //mora da se koni polje submit jer ga nema u nasoj tablici
                unset($data['submit']);
                $this->getUsersTable()->update($data,array('users_id'=>$id));
                return $this->redirect()->toRoute('index/default',array('controler'=>'index','action'=>'update','id'=>$id));
            }
        }else{
             $form->setData($this->getUsersTable()->select(array('users_id'=>$id))->current());
        }
        return new ViewModel(array('form'=>$form,'id'=>$id));

    }
    
    public function deleteAction()
    {
        $id=$this->params('id');
        if (!empty($id))
                $this->getUsersTable()->delete(array('users_id'=>$id));
        return $this->redirect()->toRoute('index/default',array('controler'=>'index','action'=>'index'));
    }

    public function registerAction()
        {
            $view = new ViewModel();
            $view->setTemplate('users/index/new-user');
            return $view;
        }
        public function loginAction()
        {
            $view = new ViewModel();
            $view->setTemplate('users/index/login');
            return $view;
        }

    public function getUsersTable()
    {
    	 if (!$this->usersTable){
    	 	$this->usersTable = new TableGateway(
    	 			'users',
    	 			$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter')

    	 		);   	 	
    	 }
    	 return $this->usersTable;
    }
}
