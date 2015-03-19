<?php

class Application_Model_Forums extends Zend_Db_Table_Abstract
{
    protected $_name = "forums";
    
    function addForum($data){
        $row = $this->createRow();
        $row->name = $data['name'];
        $row->image = $data['image'];
        $row->is_locked = $data['is_locked'];
        $row->cat_id = $data['cat_id'];
               
        return $row->save();
    }
    
    function listForum(){
        
        return $this->fetchAll()->toArray();
    }
    
    function getForumById($id){
        return $this->find($id)->toArray();
    }
    
    function getForumsByCategoryId($cat_id)
    {
        $forums = $this->select()->where("cat_id = $cat_id");
        return $this->fetchAll($forums)->toArray();
    }
    
    function lockForum($data){
        $this->update($data['is_locked'], "id=".$data['id']);
        return $this->fetchAll()->toArray();       
    }
            
    function editForum($data){
         if (empty($data['name'])) {
           unset($data['name']);
        }
        
        if (empty($data['image'])) {
           unset($data['image']);
        }
        
        if (empty($data['is_locked'])) {
           unset($data['is_locked']);
        }

        $this->update($data, "id=".$data['id']);
        return $this->fetchAll()->toArray();
    }
    
    function deleteForum($id){
        return $this->delete("id=$id");
    }


}

