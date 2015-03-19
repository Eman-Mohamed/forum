<?php

class Application_Model_Categories extends Zend_Db_Table_Abstract
{
    protected $_name = "categories";
    
    function addCategory($data){
        $row = $this->createRow();
        $row->name = $data['name'];
        return $row->save();
    }
    
    function listCategory(){
        
        return $this->fetchAll()->toArray();
    }
    
    function getCategoryById($id){
        return $this->find($id)->toArray();
    }
            
    function editCategory($data){
         if (empty($data['name'])) {
           unset($data['name']);
        }

        $this->update($data, "id=".$data['id']);
        return $this->fetchAll()->toArray();
    }
    
    function deleteCategory($id){
        return $this->delete("id=$id");
    }


}

