<?php

require_once 'Zend/Mail.php';
require_once 'Zend/Mail/Transport/Smtp.php';
?>

<?php

class UsersController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
        $authorization = Zend_Auth::getInstance();
//  if(!$authorization->hasIdentity() && $this->_request->getActionName()!='register')
//      { $this->redirect("users/register"); }
    }

    public function indexAction() {
        
    }

    public function listAction() {
        $user_model = new Application_Model_Users();
        $this->view->users = $user_model->listUsers();
    }

    public function deleteAction() {
        $id = $this->_request->getParam("id");
        if (!empty($id)) {
            $user_model = new Application_Model_Users();
            $user_model->deleteUser($id);
        }
        $this->redirect("users/list");
    }

    public function editAction() {
        $id = $this->_request->getParam("id");
        $form = new Application_Form_Users();
        if ($this->_request->isPost()) {
            if ($form->isValid($this->_request->getParams())) {
                $user_info = $form->getValues();
                $user_model = new Application_Model_Users();
                $user_model->editUser($user_info);
            }
            if (!empty($id)) {
                $user_model = new Application_Model_Users();
                $user = $user_model->getUserById($id);
                var_dump($user);

                $form->populate($user[0]);
            } else
                $this->redirect("users/list");
        }
        $form->getElement("password")->setRequired(false);
        $this->view->form = $form;
        $this->render('add');
    }

    public function addAction() {
        $form = new Application_Form_Users();

        if ($this->_request->isPost()) {
            if ($form->isValid($this->_request->getParams())) {
                $user_info = $form->getValues();
                $user_model = new Application_Model_Users();
                $user_model->addUser($user_info);
            }
        }

        $this->view->form = $form;
    }

    public function loginAction() {

        $login_form = new Application_Form_Users();
        $login_form->removeElement("name");
        $login_form->removeElement("id");
        $this->view->login = $login_form;

        $login_model = new Application_Model_Login();
        if ($login_form->isValid($_POST)) {
            $email = $this->_request->getParam('email');
            $password = $this->_request->getParam('password');
            $db = Zend_Db_Table::getDefaultAdapter();
            $authAdapter = new Zend_Auth_Adapter_DbTable($db, 'student', 'email', 'password');

            $authAdapter->setIdentity($email);
            $authAdapter->setCredential(md5($password));
            $result = $authAdapter->authenticate();
            if ($result->isValid()) {
                $auth = Zend_Auth::getInstance();
                $storage = $auth->getStorage();
                $storage->write($authAdapter->getResultRowObject(array('email', 'password')));
                $this->_redirect('users/list');
                echo "welcome";
            }
        }
    }

    public function homeAction() {
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
        if (!$data) {
//            $this->_redirect('users/login');
        }
        $this->view->name = $data['name'];
    }

    public function registerAction() {
        $register_model = new Application_Model_Users();
        $form = new Application_Form_Registration();
        $this->view->register = $form;
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                $data = $form->getValues();
                $data = $this->preparedata($data);

                if ($register_model->checkUnique($data['email'])) {
                    $this->view->errorMessage = "Name already taken. Please choose      another one.";
                    return;
                }

                $register_model->insert($data);
//                $this->_redirect('users/home');
                $this->sendConfirmationEmail($data);
            }
        }
    }

    public function sendConfirmationEmail($data) {

        $config = array('ssl' => 'ssl',
            'port' => '465',
            'auth' => 'login',
            'username' => 'smagdy215@gmail.com',
            'password' => '0111650924');
        $transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $config);


        $mail = new Zend_Mail();

        $mail->setType(Zend_Mime::MULTIPART_RELATED);

        $mail->setFrom('smagdy215@gmail.com', 'Example');
        $mail->addTo($data['email'], 'Username');
        $mail->setSubject('please confirm your registeration');

//        $mail->setBodyText("please click the code to confirm your registeration check the link below " .
//                
////              $this->getRequest()->getServer('HTTP_ORIGIN') .
//               $this->_helper->url->url(array(
//                   'controller' => 'users',
//                    'action' => 'confirm-email'
//                    )));
////         $this->_helper->url->url(array('controller'=>'users','action'=>'confirm-email'));

        $prefix = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on' ? 'https' : 'http';
        $server_name = $_SERVER['SERVER_NAME'];

        $url = $this->_helper->url->url(
                array(
            'controller' => 'users',
            'action' => 'confirm-email'
        ));
    
        
       

        /* PLEASE REPLACE THE above 'ROUTE_NAME' WITH THE ONE YOU MUST HAVE USED FOR 'registration' CONTROLLER */

        $full_url = $prefix . "://" . $server_name . $url;

        $mail->setBodyText("Please, click the link to confirm your registration => " .
                $this->getRequest()->getServer('HTTP_ORIGIN') .
                $full_url
        );



        try {
            $mail->send($transport);
            echo "Message sent!<br />\n";
        } catch (Exception $ex) {
            echo "Failed to send mail! " . $ex->getMessage() . "<br />\n";
        }
    }
    
     public function confirmEmailAction(){
            
        }

    public function preparedata($data) {
        $data['password'] = md5($data['password']);
        $date = new DateTime();
        $data['user_registeration_date'] = $date->format('Y-m-d M:i:s');
        return $data;
    }

    public function logoutAction() {
        $this->_redirect('users/login');
    }

}
