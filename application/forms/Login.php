<?php

class Application_Form_Login extends Zend_Form
{

    public function init()
    {
          $this->setMethod('post');

        $this->addElement(
            'text', 'email', array(
            'label' => 'Email:',
            'required' => true,
            'filters'    => array('StringTrim'),
        ));
       $this->setAttrib("class", "form-control");
       $this->setAttrib("placeholder", "Email");

        $this->addElement('password', 'password', array(
            'label' => 'Password:',
            'required' => true,
        ));
    }


}

