<?php

namespace Users\Model;

class ImageUpload {

    public $id;
    public $filename;
    public $thumbnail;
    public $label;
    public $user_id;

	function exchangeArray($data) {
	    $this->label = (isset($data['label'])) ?
	            $data['label'] : null;
	    $this->filename = (isset($data['filename'])) ?
	            $data['filename'] : null;
	   $this->thumbnail = '';
	  	$this->user_id = (isset($data['user_id'])) ?
	            $data['user_id'] : null;	  
	}
}