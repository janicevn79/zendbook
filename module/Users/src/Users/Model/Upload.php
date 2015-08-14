<?php

namespace Users\Model;

class Upload {

    public $id;
    public $filename;
    public $label;
    public $user_id;

	function exchangeArray($data) {
	    $this->label = (isset($data['label'])) ?
	            $data['label'] : null;
	    $this->filename = (isset($data['filename'])) ?
	            $data['filename'] : null;
	  	$this->user_id = (isset($data['user_id'])) ?
	            $data['user_id'] : null;	  
	}
}