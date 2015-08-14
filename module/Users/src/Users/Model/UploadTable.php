<?php

namespace Users\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class UploadTable {

    public $tableGateway;

    public $uploadSharingTableGateway;

    public function __construct(TableGateway $tableGateway, TableGateway $uploadSharingTableGateway){
        $this->tableGateway = $tableGateway;
        $this->uploadSharingTableGateway = $uploadSharingTableGateway;
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

    public function addSharing($uploadId, $userId) {
        $data = array(
            'upload_id' => (int) $uploadId,
            'user_id' => (int) $userId,
        );
        $this->uploadSharingTableGateway->insert($data);
    }

    public function removeSharing($uploadId, $userId) {
        $data = array(
            'upload_id' => (int) $uploadId,
            'user_id' => (int) $userId,
        );
        $this->uploadSharingTableGateway->delete($data);
    }

    public function getSharedUsers($uploadId) {
        $uploadId = (int) $uploadId;
        $rowset = $this->uploadSharingTableGateway->select(
                array('upload_id' => $uploadId));
        return $rowset;
    }

    public function getSharedUploadsForUserId($userId) {
        $userId = (int) $userId;
        $rowset = $this->uploadSharingTableGateway->select(
                function (Select $select) use ($userId) {
            $select->columns(array())
                    ->where(array('uploads_sharing.user_id' => $userId))
                    ->join('uploads', 'uploads_sharing.upload_id = uploads.id');
        });
        return $rowset;
    }

}
