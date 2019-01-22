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

    public function index()
    {
        if (!$this->session->userdata('username')) {
            // if the user is not logged in redirect them to the login page
            redirect(site_url() . '/userController/loadLogin');
        } else {
            $this->loadWishList();
        }
    }

    /**
     * REST api method used to get wish list items of a user.
     * Sends isValid as false.
     */
    public function items_get()
    {
        $userId = $this->get('userId');
        $this->load->model('Item');
        $result = $this->Item->getAllItems($userId);
        echo json_encode($result);//TODO: check this to use the correct way
//        if ($result) {
//            $this->response (array('isValid' => true, 'result' => $result), REST_Controller::HTTP_OK);
//        } else {
//            $this->response(array('isValid' => false), REST_Controller::HTTP_NOT_FOUND);
//        }
    }

    /**
     * REST api method used to remove an item from a users's wish list.
     * Sends isValid as false.
     * @param $itemId integer id of the iteme to be deleted
     */
    public function items_delete($itemId)
    {
        $this->load->model('Item');
        $result = $this->Item->deleteItem($itemId);
        if ($result) {
            $this->response (array('isValid' => true), REST_Controller::HTTP_NO_CONTENT);
        } else {
            $this->response(array('isValid' => false), REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    /**
     * REST api method used to remove an item from a users's wish list.
     * Sends isValid as false.
     */
    public function items_put()
    {
        $itemId = $this->get('itemId');
        $title = $this->get('title');
        $url = $this->get('url');
        $price = $this->get('price');
        $priority = $this->get('priority');
        $this->load->model('Item');
        $result = $this->Item->updateItem($itemId, array('title' => $title, 'url' => $url, 'price' => $price,
            'priority' => $priority));
        if ($result) {
            $this->response (array('isValid' => true), REST_Controller::HTTP_OK);
        } else {
            $this->response(array('isValid' => false), REST_Controller::HTTP_BAD_REQUEST);
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

    /**
     * Controls getting data(item details) from view and adding the item to the user wish list.
     * @return String
     */
    public function addItemToUserList()
    {
        if ($this->upload->do_upload("imgURL")) {
            $data = array('upload_data' => $this->upload->data());
            $image = $data['upload_data']['file_name'];

            $title = $this->input->post('title');
            $author = $this->input->post('author');
            $isbn = $this->input->post('isbn');
            $mainCategory = $this->input->post('mainCategorySelect');
            $subCategory = $this->input->post('subCategorySelect');
            $publisher = $this->input->post('publisher');
            $edition = $this->input->post('edition');
            $price = $this->input->post('price');
            $quantity = $this->input->post('quantity');
            $description = $this->input->post('description');
            $img = 'img/product/' . $image;

            $this->load->model('Item');
            // check whether the entered author name exists. If not add the author.
            if (!$this->Book->isAuthorAvailable($author)) {
                $this->Book->addAuthor(array('authorName' => $author));
            }

            // check whether the entered main category exists. If not add the main category.
            if (!$this->Book->isCategoryAvailable($mainCategory)) {
                $categoryData = array();
                array_push($categoryData, array('categoryTitle' => $mainCategory));
                $this->Book->createBookCategories($categoryData);
            }

            // check whether the entered sub category exists. If not add the sub category.
            if (!$this->Book->isSubCategoryAvailableInMainCategory($subCategory, $mainCategory)) {
                $subCategoryData = array();
                array_push($subCategoryData, array('subCategoryTitle' => $subCategory, 'categoryTitle' => 
                    $mainCategory));
                $this->Book->createBookSubCategories($subCategoryData);
            }

            $newEntry = array('isbnNo' => $isbn,
                'title' => $title,
                'categoryTitle' => $mainCategory,
                'subCategoryTitle' => $subCategory,
                'authorName' => $author,
                'publisherName' => $publisher,
                'price' => number_format((float)$price, 2, '.', ''),
                'availableCopies' => $quantity,
                'description' => $description,
                'edition' => $edition,
                'imageURL' => $img);
            $result = $this->Book->addBook($newEntry);
            $data = array();
            // flag determines the validity
            $flag = false;
            if ($result) {
                $flag = TRUE;
            }
            // get updated authors
            $result2 = $this->Book->getAllAuthors();
            // if results not found false will be returned
            $authors = array();
            if (!$result2) {
                $flag = false;
            } else {
                foreach ($result2 as $row) {
                    // row is an object, attributes are columns in the table
                    $authors[] = $row->authorName;
                }
            }
            $data['result'] = $flag;
            $data['authors'] = $authors;
            echo json_encode($data);
        }
    }
}

?>