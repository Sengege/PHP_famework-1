<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/classes/constants/Constants.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Model.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Database.php');


/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 25/03/2016
 * Time: 09:20
 */

/**
 * Redirect to new location
 *
 * @param $new_location
 */
function redirect_to($new_location){
    header("Location: " . $new_location);
    exit;
}

function registerUserForSession($user_id){
    $_SESSION["user_id"] = $user_id;
}

function updateSession(){
    if( !isset($_SESSION['last_access']) || (time() - $_SESSION['last_access']) > 60 )
        $_SESSION['last_access'] = time();
}

 function getIdFromDescription($table, $column, $values, $column_to_return){
    $db_connection = Database::getInstance();
    $db_model = new Model($db_connection);
    $row = $db_model->readFirst($table, $column, $values);
    return $row[$column_to_return];
}