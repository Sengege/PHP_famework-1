<?php
/**
 * Created by PhpStorm.
 * User: adamkisala
 * Date: 25/05/2016
 * Time: 09:10
 */
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/helpers/functions.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Model.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Database.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/constants/Constants.php');

if (isset($_SESSION['user_id'])) {
    if (isset($_POST['submit'])) {
        if (!empty($_POST['message'])){
            $db_connection = Database::getInstance();
            $db_model = new Model($db_connection);

            $message = $_POST['message'];
            $user_id = $_POST['user_id'];
            $message_thread_id = $_POST['message_thread_id'];

            $values = array('user_id'=>$user_id, 'message_body'=>$message, 'message_thread_id'=>$message_thread_id, 'sent'=>1);
            $db_model->insert(MESSAGE_TABLE, $values);

            redirect_to(PATH_TO_VIEWS . 'myprofile.php?active_tab=mymessages' . '&message=' . MESSAGE_SENT_INDEX);
        } else {
            redirect_to(PATH_TO_VIEWS . 'myprofile.php?' . 'error=' . TEXT_AREA_EMPTY_INDEX .'&active_tab=mymessages' );
        }
    }
}