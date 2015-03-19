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
       $title->addValidator(new Zend_Validate_Alnum());
        $title->addFilter(new Zend_Filter_StripTags);
        
       
         $image = new Zend_Form_Element_File("image");
         $image->setLabel("Choose Image");
         
         $lock=new Zend_Form_Element_Radio("lock");
         $lock->setLabel("Forum Status ");
         $lock->setRequired();
        // $lock->setAttrib("class","radio-inline");
         $lock->setMultiOptions(array('lock' => 'Lock',
        'notlocked' => 'Not Lock'));
         
         $cat=new Zend_Form_Element_Select("Category");
         $cat->setLabel('Choose Category ');
         $cat->setAttrib("class", "form-control");
         $cat->setMultiOptions(array(
             '' => 'Categories',
             '0' => 'French',
             '1' => 'English',
             '2' => 'Japanese',
             '3' => 'Chinese',
     ));
                         
        $id = new Zend_Form_Element_Hidden("id");
        
        $submit = new Zend_Form_Element_Submit("submit");
        $submit->setAttrib("class", "btn btn-primary");
        
        $this->addElements(array($id,$title,$image,$cat,$lock,$submit));
    }


}

