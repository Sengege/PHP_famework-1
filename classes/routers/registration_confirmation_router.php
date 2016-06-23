<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
/**
 * Created by PhpStorm.
 * User: adamkisala
 * Date: 16/04/2016
 * Time: 15:15
 */
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/helpers/functions.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/models/User.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Model.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Database.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/constants/Constants.php');

if(isset($_GET["user_id"]) && isset($_GET["verification_code"])){
    $user_id = urlencode($_GET["user_id"]);
    $verification_code = urlencode($_GET["verification_code"]);

    $db_connection = Database::getInstance();
    $db_model = new Model($db_connection);

    $user = $db_model->readFirst(USERS_TABLE, 'user_id', $user_id);

    if($user != null){
        if((int)($user["confirmation_key"]) === (int)$verification_code){
            $values = array('registered' => 1);
            $result = $db_model->update(USERS_TABLE, 'user_id', (int)$user_id, $values);

            if ($result){
                registerUserForSession($user_id);
                redirect_to(PATH_TO_VIEWS . 'home.php?user_id=' . $user_id);
            } else {
                //TODO failed to update error message
                echo "Failed to update registration";
                redirect_to(HOME_PAGE_PATH . "?error=failedtoupdate");
            }

        }
    } else {
        //TODO add error

        redirect_to(HOME_PAGE_PATH . "?error=getNotSET");
    }
}