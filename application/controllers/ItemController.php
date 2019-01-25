<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

/**
 * ItemController Class
 *
 * This class represent all the controller work related to items of a list.
 *
 * @author Raveen Savinda Rathnayake
 */
class ItemController extends REST_Controller
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
     * REST api method used to get wish list items of a user.
     * Sends isValid as false if not successful.
     */
    public function items_get()
    {
        $userId = $this->get('userId');
        $this->load->model('Item');
        $result = $this->Item->getAllItems($userId);
        if ($result) {
            $this->response ($result, REST_Controller::HTTP_OK);
        } else {
            $this->response($result, REST_Controller::HTTP_NO_CONTENT);
        }
    }

    /**
     * REST api method used to remove an item from a users's wish list.
     * Sends isValid as false if not successful.
     * @param $itemId integer id of the item to be deleted
     */
    public function items_delete($itemId)
    {
        $this->load->model('Item');
        $result = $this->Item->deleteItem($itemId);
        if ($result) {
            $this->response (array('isValid' => true), REST_Controller::HTTP_OK);
        } else {
            $this->response(array('isValid' => false), REST_Controller::HTTP_NO_CONTENT);
        }
    }

    /**
     * REST api method used to update an item from a users's wish list.
     * Sends isValid as false if not successful.
     * @param $itemId integer id of the item needed to be update
     */
    public function items_put($itemId)
    {
        $title = $this->put('title');
        $url = $this->put('url');
        $price = number_format((float)$this->put('price'), 2, '.', '');
        $priority = (int)$this->put('priority');
        $this->load->model('Item');
        $result = $this->Item->updateItem($itemId, array('title' => $title, 'url' => $url, 'price' => $price,
            'priority' => $priority));
        if ($result) {
            $this->response (array('isValid' => true), REST_Controller::HTTP_OK);
        } else {
            $this->response(array('isValid' => false), REST_Controller::HTTP_NO_CONTENT);
        }
    }

    /**
     * REST api method used to add an item to a users's wish list.
     * Sends isValid as false if not successful.
     */
    public function items_post()
    {
        $userId = (int)$this->post('userId');
        $title = $this->post('title');
        $url = $this->post('url');
        $price = number_format((float)$this->post('price'), 2, '.', '');
        $priority = (int)$this->post('priority');
        $this->load->model('Item');
        $result = $this->Item->addItem(array('title' => $title, 'url' => $url, 'price' => $price,
            'priority' => $priority, 'userId' => $userId));
        if ($result) {
            $this->response (array('itemId' => $result), REST_Controller::HTTP_CREATED);
        } else {
            $this->response(array('isValid' => false), REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    /**
     * REST api method used to get wish list items of a user.
     * Sends isValid as false if not successful.
     * @param $userId integer id of the user who owns the wish list
     */
    public function showlist_get($userId)
    {
        $this->load->model('Item');
        $result = $this->Item->getAllItems($userId);
        $this->load->model('User');
        $userDetails = $this->User->getUser($userId);
        if ($result) {
            $data['items'] = $result;
            $data['name'] = $userDetails[0]->name;
            $data['listName'] = $userDetails[0]->listName;
            $data['listDescription'] = $userDetails[0]->listDescription;
            $this->load->view('VisitorListView', $data);
        } else if ($userDetails){
            $data['name'] = $userDetails[0]->name;
            $data['listName'] = $userDetails[0]->listName;
            $data['listDescription'] = $userDetails[0]->listDescription;
            $this->load->view('VisitorListView', $data);
        } else {
            $this->load->view('HomeView');
        }
    }

    /**
     * Controls validating the title of an item.
     * @return String
     */
    public function validateItemTitle()
    {
        $title = $_POST['title'];
        $userId = $_POST['userId'];
        $this->load->model('Item');
        $result = $this->Item->isItemTitleAvailableForUser($title, $userId);
        // flag determines the validity of the isbn number
        $flag = false;
        if (!$result) {
            // if results not found that means isbn is not in the db. Hence flag will be TRUE.
            $flag = TRUE;
        }
        echo json_encode($flag);
    }
}

?>