<?php
/**
 * Created by PhpStorm.
 * User: adamkisala
 * Date: 08/05/2016
 * Time: 18:25
 */

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/helpers/functions.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Model.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Database.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/constants/Constants.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/models/Item.php');


$db_connection = Database::getInstance();
$db_model = new Model($db_connection);

if (isset($_POST['submit'])){

    $offeror_item_id = $_POST['offeror_item_id'];
    $acceptor_item_id = $_POST['acceptor_item_id'];
    $message = $_POST['message'];

    $offeror_item = Item::__constructWithIdFromDB($offeror_item_id);
    $acceptor_item = Item::__constructWithIdFromDB($acceptor_item_id);

    $check_duplicate = $db_model->readTwoKeys(EXCHANGE_TABLE, 'item_id_offeror', $offeror_item->getItemId(), 'item_id_acceptor', $acceptor_item->getItemId());

    if ($check_duplicate){
        redirect_to(PATH_TO_VIEWS . 'home.php?error=2');
        
    } else {
        $values = array('user_id_offeror'=>$offeror_item->getUserId(), 'user_id_acceptor'=>$acceptor_item->getUserId(), 'item_id_offeror'=>$offeror_item->getItemId(),
            'item_id_acceptor'=>$acceptor_item->getItemId(), 'status_type_id'=>EXCHANGE_STATUS_OFFERED, 'description'=>$message);
        $result = $db_model->insert(EXCHANGE_TABLE, $values);
        if ($result){
            redirect_to(PATH_TO_VIEWS . 'myprofile.php');
        } else {
            //something went wrong while inserting to DB
            //TODO display errors
            redirect_to(PATH_TO_VIEWS . 'home.php?errors=true');
        }
    }

} else {
    redirect_to(PATH_TO_VIEWS . 'home.php');
}