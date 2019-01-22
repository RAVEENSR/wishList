<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
/**
 * UserController Class
 *
 * This class controls the operations related to users.
 *
 * @author Raveen Savinda Rathnayake
 */
class UserController  extends REST_Controller
{

    public function __construct()
    {
        // Parent constructor call
        parent::__construct();
    }

    public function index_get()
    {
       $this->load->view('HomeView');
    }

    /**
     * Loads the view for login.
     */
    public function loadLogin() //TODO: check the neediness of this
    {
        $this->load->view('HomeView');
    }

    /**
     * Loads the view for registering a user.
     */
    public function loadRegister()
    {
//        if ($this->session->userdata('username') != '') {
//            $this->load->view('HomeView');
//        } else {
            $this->load->view('visitor/Header');
            $this->load->view('visitor/Register');
            $this->load->view('visitor/Footer');
//        }
    }

    /**
     * REST api method used for user login. Sends the user data if found, otherwise sends isValid as false.
     */
    public function user_get() {
        $username = $this->get ( 'username' );
        $password = $this->get ( 'password' );
        $this->load->model('User');
        $result = $this->User->login($username, $password);
        if ($result) {
            $this->response (array('isValid' => true, 'result' => $result), REST_Controller::HTTP_OK);
            $userdata
                = array('userId' => $result->userId, 'username' => $username, 'logged_in' => TRUE);
            $this->session->set_userdata ($userdata);
        } else {
            $this->response(array('isValid' => false), REST_Controller::HTTP_NOT_FOUND);
        }
    }

    /**
     * This REST api method will called when post is called for resource user.
     */
    public function user_post() {
        // adding new user to the database through user model
        $this->load->model('User');
        $data = $this->User->register($this->post( 'username'), $this->post( 'password'),
            $this->post( 'name'), $this->post ( 'listName'), $this->post( 'listDescription'));
        $this->response($data, REST_Controller::HTTP_CREATED);
    }

    /**
     * This REST api method will called when post is called for resource logout.
     * This methods destroys the session and send response back to client
     */
    function logout_post() {
        $this->session->unset_userdata('userId');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('logged_in');
        $this->session->sess_destroy ();
        $this->response (array('result' => "log out successfully"), REST_Controller::HTTP_OK);
    }

//    /**
//     * Controls authenticating the user login credentials.
//     */
//    public function authenticate()
//    {
//        // load the form validation library
//        $this->form_validation->set_rules('username', 'Username', 'required');
//        $this->form_validation->set_rules('password', 'Password', 'required');
//        if ($this->form_validation->run()) {
//            $username = $_POST['username'];
//            $password = $_POST['password'];
//            //$passwordHash = password_hash($password, PASSWORD_DEFAULT);
//            $this->load->model('User');
//            $result = $this->User->login($username, $password);
//            if ($result) {
//                $userId = $result->userId;//TODO: check
//                $session_data = array('username' => $username, 'userId' => $userId);
//                $this->session->set_userdata($session_data);
//                redirect(site_url() . '/iemController/loadWishList');
//            } else {
//                $this->session->set_flashdata('error', 'Invalid Username and Password!');
//                redirect(site_url() . '/userController/loadLogin');
//            }
//        } else {
//            $this->loadLogin();
//        }
//    }

//    /**
//     * Controls admin user logging out process.
//     */
//    public function logout()
//    {
//        $this->session->unset_userdata('username');
//        $this->session->unset_userdata('userId');
//        $this->load->view('HomeView');
//    }

    /**
     * Controls admin registering process.
     */
    public function registerUser()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $name = $_POST['name'];
        $listName = $_POST['listName'];
        $listDescription = $_POST['listDescription'];
        $this->load->model('User');
//$this->User->register($username, password_hash($password, PASSWORD_DEFAULT), $name, $listName,
//            $listDescription);
        $this->User->register($username, $password, $name, $listName, $listDescription);
        //TODO: handle the error when adding an user
        $this->load->view('HomeView');
    }
}

?>