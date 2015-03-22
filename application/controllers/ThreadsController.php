<?php

class ThreadsController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }
    
     public function listAction()
    {
        $thread_model = new Application_Model_Threads();
        $id = $this->_request->getParam("id"); 
        $this->view->threads = $thread_model->getThreadsByForumId($id);
    }
    
    public function deleteAction()
    {
        $id = $this->_request->getParam("id");
        if(!empty($id)){
            $forumId = $this->_request->getParam("forumId");
            $thread_model = new Application_Model_Threads();
            $thread_model->deleteThread($id);
        }
      
          $this->redirect("threads/list/id/$forumId");
      
    }
    
     public function lockAction()
    {
        $thread_model = new Application_Model_Threads();
        $id = $this->_request->getParam("id");
        $lock = $this->_request->getParam("lock");
        $formId = $this->_request->getParam("formId");
        $this->view->forums = $thread_model->lockthread($id,$lock);
        $this->redirect("threads/list/id/$formId");
    }

    
     public function stickyAction()
    {
        $thread_model = new Application_Model_Threads();
        $id = $this->_request->getParam("id");
        $formId = $this->_request->getParam("formId");
        $this->view->forums = $thread_model->stickthread($id);
        $this->redirect("threads/list/id/$formId");
    }

}

