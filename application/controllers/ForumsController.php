<?php

class ForumsController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }
    
    public function addAction()
    {
        $form  = new Application_Form_Forum();
       
       if($this->_request->isPost()){
           if($form->isValid($this->_request->getParams())){
               $forum_info = $form->getValues();
             
               $name=$forum_info["name"];
               $catgId=$forum_info["cat_id"];
               $forum_model = new Application_Model_Forums();
               $result=$forum_model->checkForums(array($catgId,$name));
               if($result)
               {
                   echo "There is a forum with that name in this category";
               }
               else
               {
                    $forum_model->addForum($forum_info);
               }       
           }
       }
       
	$this->view->form = $form;
    }

    public function deleteAction()
    {
        $id = $this->_request->getParam("id");
        if(!empty($id)){
            $forum_model = new Application_Model_Forums();
            $forum_model->deleteForum($id);
        }
           $this->redirect("forum/list");
      
    }

    public function editAction()
    {
        $id = $this->_request->getParam("id");
        $form  = new Application_Form_Forum();
        if($this->_request->isPost())
        {
           if($form->isValid($this->_request->getParams()))
            {
               $forum_info = $form->getValues();
               $forum_model = new Application_Model_Forums();
               $forum_model->editForum ($forum_info);                       
           }
        }
        if (!empty($id)) 
        {
            $forum_model = new Application_Model_Post();
            $forum = $forum_model->getPostById($id);
           //var_dump($forum);
            $form->populate($forum[0]);
        } 
        else 
        {
            $this->redirect("forum/list");
        }  
        
        $form->getElement("name")->setRequired(false);
        $form->getElement("is_locked")->setRequired(false);
        
        $this->view->form = $form;
	$this->render('add');
    }

    public function listAction()
    {
        $forum_model = new Application_Model_Forums();
        $this->view->forums = $forum_model->listForum();
    }


}

