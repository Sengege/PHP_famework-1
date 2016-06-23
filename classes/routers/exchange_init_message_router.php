<?php
/**
 * Created by PhpStorm.
 * User: adamkisala
 * Date: 25/05/2016
 * Time: 05:44
 */

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/helpers/functions.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Model.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Database.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/constants/Constants.php');

if (isset($_SESSION['user_id'])){
    if (isset($_POST['submit'])){
        if (!empty($_POST['message'])){
            $db_connection = Database::getInstance();
            $db_model = new Model($db_connection);

            $user_id = $_POST['user_id'];
            $message = $_POST['message'];
            $exchange_id = $_POST['exchange_id'];

            $values = array('title'=>'exchange_message');
            $db_model->insert(MESSAGE_THREAD_TABLE, $values);
            $last_inserted_id = $db_model->getDb()->getLastId();

            $values = array('message_thread_id' => $last_inserted_id);
            $db_model->update(EXCHANGE_TABLE, 'exchange_id', $exchange_id, $values);

            $values = array('message_thread_id' => $last_inserted_id, 'user_id'=> $user_id, 'message_body'=>$message);
            $db_model->insert(MESSAGE_TABLE, $values);

        } else {
            redirect_to(PATH_TO_VIEWS . 'home.php?error=' . TEXT_AREA_EMPTY_INDEX);
        }
    } else {
        redirect_to(PATH_TO_VIEWS . 'home.php?error=' . GENERIC_ERROR_INDEX);
    }
    redirect_to(PATH_TO_VIEWS . 'myprofile.php?active_tab=mymessages&message=' . MESSAGE_SENT_INDEX);
} else {
    $login = new Login();
    $login->doLogout();
    redirect_to(PATH_TO_VIEWS . 'home.php?error=' . MESSAGE_LOGGED_OUT_INDEX);
}
