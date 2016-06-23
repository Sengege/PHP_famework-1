<?php
/**
 * Created by PhpStorm.
 * User: adamkisala
 * Date: 07/05/2016
 * Time: 16:27
 */

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/constants/Constants.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/collections/WishListCollection.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/helpers/functions.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/models/User.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/models/Item.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Model.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Database.php');

$db_connection = Database::getInstance();
$db_model = new Model($db_connection);
$TRUE = 'true';
$FALSE = 'false';

if (isset($_POST['user_id']) && isset($_POST['item_id'])
    &&
    !empty($_POST['user_id']) && !empty($_POST['item_id'])
    && $_POST['user_id'] > 0){

    $user_id = $_POST['user_id'];
    $item_id = $_POST['item_id'];

    $wish_list = new WishListCollection();

    $result = $wish_list->addRemoveItemToWishList($user_id, $item_id);

    if($result == REMOVED_FROM_WISH_LIST){
        $item = $db_model->readFirst(ITEMS_TABLE, 'item_id', $item_id);
        $likes = $item['likes'] - 1;
        $values = array('likes'=>$likes);
        $db_model->update(ITEMS_TABLE, 'item_id', $item_id, $values);
        //$json_object = array('code'=>'REMOVED', 'likes'=>$likes);
        $json_object = '{"code":"REMOVED","likes":"' . $likes.'"}';
        echo $json_object;
    } else {
        $item = $db_model->readFirst(ITEMS_TABLE, 'item_id', $item_id);
        $likes = $item['likes'] + 1;
        $values = array('likes'=>$likes);
        $db_model->update(ITEMS_TABLE, 'item_id', $item_id, $values);
        $json_object = '{"code":"ADDED","likes":"' . $likes.'"}';
        echo $json_object;
    }
    
} else {
    $values = array('user_id'=>'not set!!!');
    //echo print_r($values);
}