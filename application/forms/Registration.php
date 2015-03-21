<?php

class Application_Form_Registration extends Zend_Form
{

    public function init()
            
            
    {
        $id = $this->createElement('hidden','id');
        $name = $this->createElement('text','name');
        $name->setLabel('Name:')
                    ->setRequired(true)
                    ->addFilter('StripTags')
                    ->addFilter('StripTags');
        $email = $this->createElement('text','email');
        $email->setLabel('Email: *')
                ->setRequired(true);
                
        
                
        $password = $this->createElement('password','password');
        $password->setLabel('Password: *')
                ->setRequired(true);
        
        $gender = $this->CreateElement('radio','gender')
        ->addFilter(new Zend_Filter_StringTrim())
        ->setMultiOptions(array('M'=>'Male', 'F'=>'Female'))
        ->setDecorators(array( array('ViewHelper') ));
        
        $uploadImage = new Zend_File_Transfer_Adapter_Http();
        $uploadImage = new Zend_Form_Element_File('image');
        $uploadImage->setLabel("Upload Image ")
            ->setRequired(true)               
            ->addValidator('Extension',false,'jpg,png,gif,jpeg')
            ->setDestination("../public/profile_images")
            ->addValidator('Count',false,1) //ensure only 1 file
            ->addValidator('Size',false,102400) //limit to 100K
            ->getValidator('Extension')->setMessage('This file type is not supportted.');

        
        
        $uploadSignature = new Zend_Form_Element_File('signature');
        $uploadSignature->setLabel("Upload signature ")
            ->setRequired(true)               
            ->addValidator('Extension', false, 'jpeg,png')
            ->getValidator('Extension')->setMessage('This file type is not supportted.');

        
                
        $register = $this->createElement('submit','register');
        $register->setLabel('Sign up')
                ->setIgnore(true);
                
                
        $this->addElements(array(
                        $name,
                        $email,
                        $password,
                        $gender,
                        $uploadImage,
                        $uploadSignature,
                        $register
        ));
      
    }
}





