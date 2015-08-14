<?php

namespace Users\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class ImageUploadTable {

    public $tableGateway;


    public function __construct(TableGateway $tableGateway){
        $this->tableGateway = $tableGateway;
       
    }

    public function saveUpload(Upload $upload) {
        $data = array(
            'filename' => $upload->filename,
            'label' => $upload->label,
            'user_id' => $upload->user_id,
        );
        $uploadExist = $this->getUpload($upload->filename);

        if (empty($uploadExist)) {
            $this->tableGateway->insert($data);
        } else {
            throw new \Exception('This file is already uploaded');
        }
    }

    public function fetchAll() {

        $resultSet = $this->tableGateway->select();
        //$resultSet = $rowset->current();
        //var_dump($resultSet);exit;
        if (!$resultSet) {
            throw new \Exception("Could not find row $id");
        }
        return $resultSet;
    }

    public function getUpload($filename) {
        //$id = (int) $id;
        $rowset = $this->tableGateway->select(array('filename' => $filename));
        $row = $rowset->current();
        /*            if (!$row) {
          throw new \Exception("Could not find row ");
          } */
        return $row;
    }

    public function deleteUpload($id) {
        $id = (int) $id;
        $rowset = $this->tableGateway->delete(array('id' => $id));
        //$row = $rowset->current();
    }

    public function getUploadsByUserId($user_id) {
        $user_id = (int) $user_id;
        $rowset = $this->tableGateway->select(array('user_id' => $user_id));
        //$row = $rowset->current();
        if (!$rowset) {
            throw new \Exception("Could not find row $id");
        }
        return $rowset;
    }

    public function getUploadsById($id) {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$rowset) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

}
