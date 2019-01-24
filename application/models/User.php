<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * User Class
 *
 * This class represents database activities regarding the user login operation.
 *
 * @author Raveen Savinda Rathnayake
 */
class User extends CI_Model {

    /**
     * User Model constructor.
     */
    public function __construct() {
        // CI_Model constructor call
        parent::__construct();
        // load database object
        $this->load->database();
    }

    /**
     * Add user details to the database.
     * @param $username String Username of the user
     * @param $password String Password of the user
     * @param $name String name of the user
     * @param $listName String name of the wish list
     * @param $listDescription String description of the wish list
     * @return bool Returns true if successful, false otherwise.
     */
    public function register($username, $password, $name, $listName, $listDescription){
        $data = array('username' => $username, 'password' => $password, 'name' => $name, 'listName' => $listName,
            'listDescription' => $listDescription);
        $this->db->insert('user',$data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    /**
     * Gets the row containing username and password of user.
     * @param $username String Username of the admin
     * @return bool|ArrayObject Returns the result array if found or false if not found.
     */
    public function login($username) {
        $this->db->where('username', $username);
        $result = $this->db->get('user');
        // check the number of rows in the result
        if ($result->num_rows() !== 1) {
            return false;
        } else {
            return $result->result();
        }
    }

    /**
     * Gets the user row containing userId of the user.
     * @param $userId integer id of the user
     * @return bool|ArrayObject Returns the result array if found or false if not found.
     */
    public function getUser($userId) {
        $this->db->where('userId', $userId);
        $result = $this->db->get('user');
        // check the number of rows in the result
        if ($result->num_rows() !== 1) {
            return false;
        } else {
            return $result->result();
        }
    }

    /**
     * Checks whether a given item title is available under a given user.
     * @param $username String username of the user
     * @return bool|ArrayObject Returns the result array if found or false if not found.
     */
    public function isUserAvailable($username)
    {
        $this->db->select('userId');
        $this->db->where('username', $username);
        $result = $this->db->get('user');
        // check the number of rows in the result
        return $result->num_rows() === 1 ? $result->result() : false;
    }
}

?>