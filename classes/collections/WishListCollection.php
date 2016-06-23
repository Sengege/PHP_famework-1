<?php

/**
 * Created by PhpStorm.
 * User: adamkisala
 * Date: 07/05/2016
 * Time: 16:07
 */

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Model.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Database.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/constants/Constants.php');

/**
 * Class WishListCollection
 */
class WishListCollection
{

    /**
     * @var Model|null
     */
    private $db_model = null;
    /**
     * @var Database|null
     */
    private $db_connection = null;

    /**
     * WishListCollection constructor.
     */
    public function __construct(){
        $this->db_connection = Database::getInstance();
        $this->db_model = new Model($this->db_connection);
    }

    /**
     * @param $user_id
     * @return array
     */
    public function getItemsIdsFromWishList($user_id){
        return $items =  $this->db_model->read(WISH_LIST_TABLE, 'user_id', $user_id);
    }

    /**
     * @param $user_id
     * @param $item_id
     * @return bool
     */
    public function addRemoveItemToWishList($user_id, $item_id){
        //check if item already mapped
        $wish_list_item = $this->db_model->readTwoKeys(WISH_LIST_TABLE, 'user_id', $user_id, 'item_id', $item_id);
        if($wish_list_item) {
            $this->db_model->deleteTwoKeys(WISH_LIST_TABLE, 'user_id', 'item_id', $user_id, $item_id);
            return REMOVED_FROM_WISH_LIST;
        }
        else{
            $values = array('user_id'=>$user_id, 'item_id'=>$item_id);
            $this->db_model->insert(WISH_LIST_TABLE, $values);
            return ADDED_TO_WISH_LIST;
        }
    }

}