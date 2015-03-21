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
    
//    public function deleteAction()
//    {
//        $id = $this->_request->getParam("id");
//        if(!empty($id)){
//            $forumId = $this->_request->getParam("forumId");
//            $thread_model = new Application_Model_Threads();
//            $thread_model->deleteThread($id);
//        }
//      
//          $this->redirect("threads/list/id/$forumId");
//      
//    }


}

