<?php

namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\TableGateway\TableGateway;
use Zend\Mail;

class GroupChatController extends AbstractActionController {

    public function messageListAction() {
        $userTable = $this->getServiceLocator()->get('UserTable');
        $chatMessageTG = $this->getServiceLocator()->get('ChatMessagesTableGateway');
        $chatMessages = $chatMessageTG->select();
        $messageList = array();
        foreach ($chatMessages as $chatMessage) {
            $fromUser = $userTable->getUser($chatMessage->user_id);
            $messageData = array();
            $messageData['user'] = $fromUser->users_name;
            $messageData['time'] = $chatMessage->stamp;
            $messageData['data'] = $chatMessage->message;
            $messageList[] = $messageData;
        }
        $viewModel = new ViewModel(array('messageList' =>
            $messageList));
        $viewModel->setTemplate('users/group-chat/message-list');
        $viewModel->setTerminal(true);
        return $viewModel;
    }

    public function indexAction() {
       // $user = $this->getLoggedInUser();
         $userTable = $this->getServiceLocator()->get('UserTable');

        // Get User Info from Session
        $authService = $this->getServiceLocator()->get('AuthService');
        $userEmail = $authService->getStorage()->read();
        $user = $userTable->getUserByEmail($userEmail);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $messageTest = $request->getPost()->get('message');
            $fromUserId = $user->users_id;
            $this->sendMessage($messageTest, $fromUserId);
// to prevent duplicate entries on refresh
            return $this->redirect()->toRoute('groupy',array(
   
                'controller'=>'groupchat',
                'action'=>'index',
                'default', true

            ));
        }
//Prepare Send Message Form
        $form = new \Zend\Form\Form();
        $form->add(array(
            'name' => 'message',
            'attributes' => array(
                'type' => 'text',
                'id' => 'messageText',
                'required' => 'required'
            ),
            'options' => array(
                'label' => 'Message',
            ),
        ));
        $form->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Send'
            ),
        ));
        $form->add(array(
            'name' => 'refresh',
            'attributes' => array(
                'type' => 'button',
                'id' => 'btnRefresh',
                'value' => 'Refresh'
            ),
        ));

       

        $viewModel = new ViewModel(array('form' => $form, 'userName' => $user->users_name));
       // var_dump(123);exit;
        return $viewModel;
    }


public function contactusAction() {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $messageText = $request->getPost()->get('message');
            $send_to = $request->getPost()->get('send_to');
            //var_dump($send_to);var_dump($messageText);exit;
            //$fromUserId = $user->users_id;
            $success=$this->sendOfflineMessage('subject',$messageText, 11, $send_to);
            if ($success)
                // to prevent duplicate entries on refresh
            return $this->redirect()->toRoute('groupy',array(
   
                'controller'=>'groupchat',
                'action'=>'index',
                'default', true

            ));

        echo 'ne prateno';
        }
     //Prepare Send Email Form
        $email_form = new \Zend\Form\Form();
        $email_form->add(array(
            'name' => 'send_to',
            'attributes' => array(
                'type' => 'text',
                'id' => 'send_to',
                'required' => 'required'
            ),
            'options' => array(
                'label' => 'Send to:',
            ),
        ));
        $email_form->add(array(
            'name' => 'message',
            'attributes' => array(
                'type' => 'text',
                'id' => 'messageText',
                'required' => 'required'
            ),
            'options' => array(
                'label' => 'Message',
            ),
        ));
        $email_form->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Send'
            ),
        ));
        $viewModel = new ViewModel(array('form' => $email_form));
       // var_dump(123);exit;
        return $viewModel;
    }

    protected function sendOfflineMessage($msgSubj, $msgText, $fromUserId, $toUserId)
        {
        $userTable = $this->getServiceLocator()->get('UserTable');
        $fromUser = $userTable->getUser($fromUserId);
        $toUser = $toUserId;
        $mail = new Mail\Message();
        $mail->setFrom('janicevn79@hotmail.com', 'test');
        $mail->addTo('janicevn79@hotmail.com', 'prima');
        $mail->setSubject($msgSubj);
        $mail->setBody($msgText);
        $transport = new Mail\Transport\Sendmail();
        $transport->send($mail);
        return true;
        }

    protected function sendMessage($messageTest, $fromUserId) {
        $chatMessageTG = $this->getServiceLocator()->get('ChatMessagesTableGateway');
        $data = array(
            'user_id' => $fromUserId,
            'message' => $messageTest,
            'stamp' => NULL
        );
        $chatMessageTG->insert($data);
        return true;
    }

}
