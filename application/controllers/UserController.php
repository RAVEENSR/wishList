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
        $this->load->library('form_validation');//TODO: remove this
    }

    public function index()
    {
        if ($this->session->userdata('username') != '') {
            redirect(site_url() . '/iemController/loadWishList');
        } else {
            $this->load->view('visitor/Header');
            $this->load->view('visitor/Login');
            $this->load->view('visitor/Footer');
        }
    }

    /**
     * Loads the view for login.
     */
    public function loadLogin()
    {
        if ($this->session->userdata('username') != '') {
            redirect(site_url() . '/iemController/loadWishList');
        } else {
            $this->load->view('visitor/Header');
            $this->load->view('visitor/Login');
            $this->load->view('visitor/Footer');
        }
    }

    /**
     * Loads the view for registering a user.
     */
    public function loadRegister()
    {
        if ($this->session->userdata('username') != '') {
            redirect(site_url() . '/iemController/loadWishList');
        } else {
            $this->load->view('visitor/Header');
            $this->load->view('visitor/Register');
            $this->load->view('visitor/Footer');
        }
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

    /**
     * Controls admin user logging out process.
     */
    public function logout()
    {
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('userId');
        redirect(site_url() . '/userController/loadLogin');
    }

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
    }
}

?>