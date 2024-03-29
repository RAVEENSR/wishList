<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Item Class
 *
 * This class represents database activities regarding an item in the wish list.
 *
 * @author Raveen Savinda Rathnayake
 */
class Item extends CI_Model
{

    /**
     * Item Model constructor.
     */
    public function __construct()
    {
        // CI_Model constructor call
        parent::__construct();
        // load database object
        $this->load->database();
    }

    /**
     * Gets all the items of a user list.
     * @param $userId integer id of the user
     * @return bool|ArrayObject Returns the result array if found or false if not found.
     */
    public function getAllItems($userId)
    {
        // get the result rows from the 'item' table
        $this->db->select('*');
        $this->db->where('userId', $userId);
        $result = $this->db->get('item');
        // check the number of rows in the result
        if ($result->num_rows() == 0) {
            return false;
        } else {
            return $result->result();
        }
    }

    /**
     * Checks whether a given item title is available under a given user.
     * @param $title String title of the item
     * @param $userId integer id of the user
     * @return bool Returns true if main category title is available, false if not.
     */
    public function isItemTitleAvailableForUser($title, $userId)
    {
        // get the result row from the 'item' table
        $this->db->select('title');
        $this->db->where(array('title' => $title, 'userId' => $userId));
        $result = $this->db->get('item');
        // check the number of rows in the result
        return $result->num_rows() === 0 ? false : true;
    }

    /**
     * Adds a new item to the wish list.
     * @param $itemConfigArray ArrayObject Details of the item as an associative array
     * @return bool/ArrayObject Returns the result array if successful or false if not found.
     */
    public function addItem($itemConfigArray)
    {
        $this->db->insert('item', $itemConfigArray);
        return ($this->db->affected_rows() !== 1) ? false : $this->db->insert_id();
    }

    /**
     * Delete an item from a users's wish list.
     * @param $itemId integer id of the item to be deleted
     * @return bool Returns true if result is successful or false if not found.
     */
    public function deleteItem($itemId)
    {
        $this->db->where('itemId', $itemId);
        $this->db->delete('item');
        return ($this->db->affected_rows() !== 1) ? false : true;
    }

    /**
     * Delete an item from a users's wish list.
     * @param $itemId integer Id of the item to be updates
     * @param $itemUpdateConfigArray ArrayObject Details of the item to be updated
     * @return bool Returns true if result is successful or false if not found.
     */
    public function updateItem($itemId, $itemUpdateConfigArray)
    {
        $this->db->where('itemId', $itemId);
        $this->db->update('item', $itemUpdateConfigArray);
        return ($this->db->affected_rows() !== 1) ? false : true;
    }
}

?>