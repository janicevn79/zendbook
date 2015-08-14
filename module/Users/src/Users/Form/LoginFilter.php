<?php

namespace Users\Form;

use Zend\InputFilter\InputFilter;

class LoginFilter extends InputFilter {

    public function __construct() {
        $this->add(array(
            'name' => 'users_email',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'EmailAddress',
                    'options' => array(
                        'domain' => true,
                    ),
                ),
            ),
        ));
        $this->add(array(
            'name' => 'users_password',
            'required' => true,
        ));

    }
}