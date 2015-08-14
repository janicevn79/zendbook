<?php

    namespace Users\Model;

    use Zend\Db\Adapter\Adapter;
    use Zend\Db\ResultSet\ResultSet;
    use Zend\Db\TableGateway\TableGateway;

    class UserTable {

        public $tableGateway;

        public function __construct(TableGateway $tableGateway) {
            $this->tableGateway = $tableGateway;
        }

        public function saveUser(User $user) {
            $data = array(
                'users_email' => $user->email,
                'users_name' => $user->name,
                'users_password' => $user->password,
            );
            $userExist=$this->existUser($user->email, $user->password);
            $id = (int) $userExist;
           
            if ($id == 0) {
                $this->tableGateway->insert($data);
            } else {
                if ($this->getUser($id)) {
                    $this->tableGateway->update($data, array('users_id' => $id));
                } else {
                    throw new \Exception('User ID does not exist');
                }
            }
        }

        public function getUser($id) {
            $id = (int) $id;
            $rowset = $this->tableGateway->select(array('users_id' => $id));
            $row = $rowset->current();
            if (!$row) {
                throw new \Exception("Could not find row $id");
            }
            return $row;
        }
        
        public function existUser($email,$password) {
            //var_dump($password);exit;
            $rowset = $this->tableGateway->select(array('users_email' =>  $email, 'users_password' => $password));
            $row = $rowset->current();
            if ($row) {
                return $row['users_id'];
            }
            return false;
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
        public function getUserByEmail($email) {

            $rowset = $this->tableGateway->select(array('users_email' => $email));
            $row = $rowset->current();
            if (!$row) {
                throw new \Exception("Could not find row $id");
            }
            return $row;
        }
        public function deleteUser($id) {
            $id = (int) $id;
            $rowset = $this->tableGateway->delete(array('users_id' => $id));
            //$row = $rowset->current();
        }

/*    public function getTableGateway()
    {
         if (!$this->tableGateway){
            $this->tableGateway = new TableGateway(
                    'users',
                    $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter')

                );          
         }
         return $this->tableGateway;
    }*/
}



