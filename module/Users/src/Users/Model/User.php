<?php

namespace Users\Model;

class User {

    public $id;
    public $name;
    public $email;
    public $password;

	public function setPassword($clear_password) {
	    $this->password = md5($clear_password);
	}

	function exchangeArray($data) {
	    $this->name = (isset($data['users_name'])) ?
	            $data['users_name'] : null;
	    $this->email = (isset($data['users_email'])) ?
	            $data['users_email'] : null;
	    if (isset($data["users_password"])) {
	        $this->setPassword($data["users_password"]);
	    }
	  
	}
}
