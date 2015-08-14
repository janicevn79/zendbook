<?php

// filename : module/Users/src/Users/Form/RegisterForm.php

namespace Users\Form;

use Zend\Form\Form;

class RegisterForm extends Form {

    public function __construct($name = null) {
        parent::__construct('Register');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/formdata');
        $this->add(array(
            'name' => 'users_name',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Full Name',
            ),
        ));

        $this->add(array(
            'name' => 'users_email',
            'attributes' => array(
                'type' => 'email',
            ),
            'options' => array(
                'label' => 'Email',
            ),

        ));

       	$this->add(array(
            'name' => 'users_password',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Password',
            ),
        ));

        $this->add(array(
            'name' => 'confirm_password',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Confirme password',
            ),

        ));

        $this->add(array(
             'name' => 'submit',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Go',
                 'id' => 'submitbutton',
             ),
         ));
    }
}