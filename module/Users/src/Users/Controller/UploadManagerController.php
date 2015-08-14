<?php 
namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
/*use Zend\Form\Element\File;
use Zend\File\Transfer\Adapter\Http;*/

use Users\Model\User;
use Users\Model\Upload;
//use Users\Model\UserTable;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;


class UploadManagerController extends AbstractActionController
{
   
    public function prvaAction() {

        $uploadTable = $this->getServiceLocator()->get('UploadTable');
        $userTable = $this->getServiceLocator()->get('UserTable');

        // Get User Info from Session
        $authService = $this->getServiceLocator()->get('AuthService');
        $userEmail = $authService->getStorage()->read();
        $user = $userTable->getUserByEmail($userEmail);
        //$form = new UploadForm('upload-form');
        $form = $this->getServiceLocator()->get('UploadForm');
        $form = $this->getServiceLocator()->get('UploadForm');
        $viewModel = new ViewModel( array(
        'myUploads' => $uploadTable->getUploadsByUserId($user->users_id),
        'form'  => $form,
        ));
        return $viewModel;
    }

    public function confirmAction() {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function deleteAction() {
        $request = $this->getRequest();
        $id=$this->params('id');
        if (!empty($id))
            $uploadTable = $this->getServiceLocator()->get('UploadTable');
            $upload= $uploadTable->getUploadsById(array('id'=>$id));
            $uploadTable->deleteUpload(array('id'=>$id));
            return $this->redirect()->toRoute('uploads' , array('action' => 'prva'));
    }
    public function DownloadAction()
    {
        $uploadId = $this->params()->fromRoute('id');
        $uploadTable = $this->getServiceLocator()->get('UploadTable');
        $upload = $uploadTable->getUploadsById($uploadId);
        // Fetch Configuration from Module Config
        $uploadPath = $this->getFileUploadLocation();
        $file = file_get_contents($uploadPath ."\\" . $upload->filename);
        // Directly return the Response
        $response = $this->getEvent()->getResponse();
        $response->getHeaders()->addHeaders(array(
        'Content-Type' => 'application/octet-stream',
        'Content-Disposition' => 'attachment;filename="'
        .$upload->filename . '"',
        ));
        $response->setContent($file);
        return $response;

    }

    public function processAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            // Make certain to merge the files info!
            $File    = $this->params()->fromFiles('image-file');

            $post = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );
            
            $form = $this->getServiceLocator()->get('UploadForm');
            $form->setData($post);
            if ($form->isValid()) {
               // $data = $form->getData();


               // $size = new Size(array('min'=>2000000)); //minimum bytes filesize
                 
                $adapter = new \Zend\File\Transfer\Adapter\Http(); 
                //validator can be more than one...
                //$adapter->setValidators($File['name']);
                $adapter->setDestination($this->getFileUploadLocation());
                
                if ($adapter->receive($File['name'])) {
                    $uploadTable = $this->getServiceLocator()->get('UploadTable');
                    $userTable = $this->getServiceLocator()->get('UserTable');
                    $authService = $this->getServiceLocator()->get('AuthService');
                    $userEmail = $authService->getStorage()->read();
                    $user_info = $userTable->getUserByEmail($userEmail);
                    $upload_data=array(
                            'user_id' =>$user_info["users_id"],
                            'label' =>'prazno ne unosim iz forme',
                            'filename' =>$post["image-file"]["name"],
                        );
                    $upload= new Upload();
                    $upload->exchangeArray($upload_data);

                    $uploadTable->saveUpload($upload);
                   
                }

            // Form is valid, save the form!
            //return $this->redirect()->toRoute('upload-form/success');
        }
       return $this->redirect()->toRoute('uploads' ,
            array('action' => 'prva'
        ));

    }

    }
    
    public function getFileUploadLocation()
    {
        // Fetch Configuration from Module Config
        $config = $this->getServiceLocator()->get('config');
        return $config['module_config']['upload_location'];
    }
}