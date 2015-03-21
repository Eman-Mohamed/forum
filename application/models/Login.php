<?php

class Application_Model_Login extends Zend_Db_Table_Abstract
{
protected $_name = "users";
 function viewlogin()
    {
      return $this->fetchAll()->toArray[0]();  
    }

}

