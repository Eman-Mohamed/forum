<?php

class Application_Form_Forum extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod("post");
        $this->setAttrib("class","form-horizontal");
        
        $title = new Zend_Form_Element_Text("name");
        
        $title->setAttrib("class", "form-control");
        $title->setLabel("Title  ");
        $title->setRequired();
        $title->addValidator(new Zend_Validate_Alnum(TRUE));
        $title->addFilter(new Zend_Filter_StripTags);     
        
       
         $image = new Zend_Form_Element_File("image");
         $image->addValidator(new Zend_Validate_File_Size(2048*1024));
         $image->addValidator(new Zend_Validate_File_IsImage());
         $image->setLabel("Choose Image");
         
         $lock=new Zend_Form_Element_Radio("is_locked");
         $lock->setLabel("Forum Status ");
         $lock->setAttrib("name", "is_locked");
         $lock->setRequired();
         $lock->setMultiOptions(array('0' => 'Lock',
        '1' => 'Not Lock'));
         
         $cats=new Application_Model_Categories();
         $allCat=$cats->listCategory();
         $names[""]="Select Category";
         foreach ($allCat as $key => $value) 
         {
             $names[$value['id']] =  $value["name"];
         }
               
         $cat=new Zend_Form_Element_Select("cat_id");
         $cat->setAttrib("name", "cat_id");
         $cat->setLabel('Choose Category ');
         $cat->setAttrib("class", "form-control");
         $cat->setMultiOptions($names);
                         
        $id = new Zend_Form_Element_Hidden("id");
        
        $submit = new Zend_Form_Element_Submit("submit");
        $submit->setAttrib("class", "btn btn-primary");
        
        $this->addElements(array($id,$title,$image,$cat,$lock,$submit));
    }


}

