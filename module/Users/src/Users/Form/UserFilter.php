<?php

namespace Users\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class UserFilter extends InputFilter
{

		public function __constructor()
		{
			$this->add(array(
					'name' => 'user_name',
					'required' => false,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
						),
					'validators' => array(
							array(
									'name' => 'StringLength',
									'options' => array(
										'encoding' =>'UTF-8',
										'min' => 1,
										'max' => 100, 
										),
								),
						),
				)
			);

			$this->add(array(
					'name' => 'user_email',
					'required' => false,
					'validators' => array(
							array(
									'name' => 'EmailAddress'
								),
						),
					)
			);

			$this->add(array(
					'name' => 'user_password',
					'required' => false,
					'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
						),
					'validators' => array(
							array(
									'name' => 'StringLength',
									'options' => array(
										'encoding' =>'UTF-8',
										'min' => 6,
										'max' => 12, 
										),
								),
						),
				)
			);

			$this->add(array(
					'name' => 'user_active',
					'required' => false,
					'filters' => array(
							array('name' => 'Int'),
							
						),
					'validators' => array(
							array(
									'name' => 'Digits',
								),
						),
				)
			);
		}
}