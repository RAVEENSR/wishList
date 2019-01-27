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
class UserController extends REST_Controller
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
     * REST api method used for user login. Sends the user data if found, otherwise sends isValid as false.
     */
    public function user_get() {
        $username = $this->get ( 'username' );
        $password = $this->get ( 'password' );
        $this->load->model('User');
        $result = $this->User->login($username);
        if ($result) {
            if (password_verify($password, $result[0]->password)) {
                $this->response (array('isValid' => true, 'result' => $result), REST_Controller::HTTP_OK);
                $userdata = array('userId' => $result->userId, 'username' => $username, 'logged_in' => TRUE);
                $this->session->set_userdata ($userdata);
            } else {
                $this->response(array('isValid' => false), REST_Controller::HTTP_NO_CONTENT);
            }
        } else {
            $this->response(array('isValid' => false), REST_Controller::HTTP_NO_CONTENT);
        }
    }

    /**
     * This REST api method will called when post is called for resource user.
     */
    public function user_post() {
        // adding new user to the database through user model
        $this->load->model('User');
        $result = $this->User->register($this->post( 'username'), $this->post( 'password'),
            $this->post( 'name'), $this->post ( 'listName'), $this->post( 'listDescription'));
        if($result) {
            $this->response(array('isValid' => true), REST_Controller::HTTP_CREATED);
        } else {
            $this->response(array('isValid' => false), REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    /**
     * This REST api method will called when a user request a list sharing link.
     */
    public function shareLink_post() {
        $username = $this->post( 'username');
        $this->load->model('User');
        $result = $this->User->isUserAvailable($username);
        if($result) {
            $userId = $result[0]->userId;
            $generatedLink = "http://localhost/wishList/index.php/showlist/".$userId;
            $this->response(array('isValid' => true, 'link' => $generatedLink), REST_Controller::HTTP_CREATED);
        } else {
            $this->response(array('isValid' => false), REST_Controller::HTTP_NO_CONTENT);
        }
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
}

?>