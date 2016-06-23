<?php
/**
 * Created by PhpStorm.
 * User: adamkisala
 * Date: 13/05/2016
 * Time: 07:13
 */

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/models/Item.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/helpers/functions.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/models/User.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Model.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Database.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/constants/Constants.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/controllers/ImageController.php');

updateSession();
$db_connection = Database::getInstance();
$db_model = new Model($db_connection);

if (isset($_SESSION['user_id'])){
    if (isset($_GET['item_id'])){
        $value = $_GET['item_id'];
        $result = $db_model->delete(ITEMS_TABLE, 'item_id', $value);
        if ($result) redirect_to(PATH_TO_VIEWS . 'myprofile.php');
        else redirect_to(PATH_TO_VIEWS . 'home.php');
    }
} else {
    redirect_to(PATH_TO_VIEWS . 'home.php') ;
}