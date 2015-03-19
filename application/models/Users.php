<?php

class Application_Model_Users extends Zend_Db_Table_Abstract
{
    protected $_name = "users";
    
    function addUser($data){
        $row = $this->createRow();
        $row->name = $data['name'];
        $row->password = md5($data['password']);
        $row->email = $data['email'];
        $row->country = $data['country'];
        $row->signature = $data['signature'];
        $row->image = $data['image'];
        $row->gender = $data['gender '];
        
        return $row->save();
    }
    
    function listUsers(){
        
        return $this->fetchAll()->toArray();
    }
    
    function getUserById($id){
        return $this->find($id)->toArray();
    }
            
    function editUser($data){
        $this->update($data, "id=".$data['id']);
        return $this->fetchAll()->toArray();
    }
    
    function deleteUser($id){
        return $this->delete("id=$id");
    }


}

