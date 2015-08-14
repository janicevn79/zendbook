<?php 

/*namespace Users\Form; 

use Zend\Captcha; 
use Zend\Form\Element; 
use Zend\Form\Form; 

class UserForm  extends Form 
{ 
    public function __construct($name = null) 
    { 
        parent::__construct('users\form'); 
        
        $this->setAttribute('method', 'post'); 
        
        $this->add(array( 
            'name' => 'users_name', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'placeholder' => 'test..', 
            ), 
            'options' => array( 
                'label' => 'test', 
            ), 
        ));       
    } 
} */
//MNOGO JAK FORM GENERATOR KAO I VALIDATOR
/*http://zend-form-generator.123easywebsites.com/formgen/create*/

namespace Users\Form;

use Zend\Captcha;
use Zend\Form\Element;
use Zend\Form\Fieldset;
use Zend\Form\Form;

class UserForm extends Form
{
	public function __construct($name=null){
		parent::__construct('users'); 
 
        $this->setAttribute('method', 'post'); 
//this is form generator
/*		$this->add(array( 
            'name' => 'users_name', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'placeholder' => 'Place'
            ), 
            'options' => array( 
                'label' => 'Text', 
            ), 
        ));*/


		$this->add(array(
					'name' => 'users_name',
					'attributes' => array(
						'type' => 'text'

						),
					'options' => array(
						'label' => 'Username'
						),
				
		));

		$this->add(array(
				'name' => 'users_password',
				'attributes' => array(
					'type' => 'password',

					),
				'options' => array(
					'label' => 'password',
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
					'name' => 'users_l_id',
					'type' => 'Zend\Form\Element\Select',
					'options' => array(
						'label' => 'Role',
						'value_options' => array(
								'1' => 'Public',
								'2' => 'Member',
								'3' => 'Admin'
							),

						),
				
		));
		$this->add(array(
					'name' => 'users_lng_id',
					'type' => 'Zend\Form\Element\Select',
					'options' => array(
						'label' => 'Language',
						'value_options' => array(
								'1' => 'English',
								'2' => 'French',
								'3' => 'German'
							),

						),
				
		));

		$this->add(array(
				'name' => 'users_active',
				'type' => 'Zend\Form\Element\Select',
					'options' => array(
						'label' => 'Active',
						'value_options' => array(
								'0' => 'No',
								'1' => 'Yes'
							),

						),
			
		));

		$this->add(array(
				'name' => 'users_question',
				'attributes' => array(
					'type' => 'text',

					),
				'options' => array(
					'label' => 'Question',
					),
			
		));

		$this->add(array(
				'name' => 'users_answare',
				'attributes' => array(
					'type' => 'text',

					),
				'options' => array(
					'label' => 'Answare',
					),
			
		));

		$this->add(array(
				'name' => 'users_picture',
				'attributes' => array(
					'type' => 'text',

					),
				'options' => array(
					'label' => 'Picture URL',
					),
			
		));

		$this->add(array(
				'name' => 'users_password_salt',
				'attributes' => array(
					'type' => 'text',

					),
				'options' => array(
					'label' => 'Password salt',
					),
			
		));

		$this->add(array(
				'name' => 'users_registration_date',
				'attributes' => array(
					'type' => 'text',

					),
				'options' => array(
					'label' => 'date',
					),
			
		));

		$this->add(array(
				'name' => 'users_registration_token',
				'attributes' => array(
					'type' => 'text',

					),
				'options' => array(
					'label' => 'Token',
					),
			
		));

		$this->add(array(
				'name' => 'users_email_confirmed',
				'type' => 'Zend\Form\Element\Select',
					'options' => array(
						'label' => 'Email confirmed',
						'value_options' => array(
								'0' => 'No',
								'1' => 'Yes'
							),

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
