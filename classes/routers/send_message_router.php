<?php
/**
 * Created by PhpStorm.
 * User: adamkisala
 * Date: 24/05/2016
 * Time: 16:26
 */

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/helpers/functions.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Model.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Database.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/constants/Constants.php');

if (isset($_SESSION['user_id'])){
    if (isset($_POST['submit'])){
        if (!empty($_POST['message'])){
            $message = $_POST['message'];
            $sender_id = $_POST['sender_id'];
            $receiver_id = $_POST['user_id'];

            $db_connection = Database::getInstance();
            $db_model = new Model($db_connection);

            //check if message thread between users already exists
            //sender may be receiver so do check
            $message_thread = $db_model->readTwoKeys(MESSAGE_THREAD_TABLE, 'sender_id', $sender_id, 'receiver_id', $receiver_id);
            if (count($message_thread)<= 0 || $message_thread[0]['message_thread_id'] == null || empty($message_thread[0]['message_thread_id'])){
                $message_thread = $db_model->readTwoKeys(MESSAGE_THREAD_TABLE, 'sender_id', $receiver_id, 'receiver_id', $sender_id);
            }
            if ($message_thread[0]['message_thread_id'] != null || !empty($message_thread[0]['message_thread_id'])){
                $message_values = array('message_thread_id'=>$message_thread[0]['message_thread_id'], 'user_id'=>$sender_id,
                    'sent'=>1, 'message_body'=>$message);
                $db_model->insert(MESSAGE_TABLE, $message_values);
            } else {
                //that thread doesn't exist yet so create one
                $values = array('sender_id'=>$sender_id, 'receiver_id'=>$receiver_id);
                $db_model->insert(MESSAGE_THREAD_TABLE, $values);
                //get last inserted id
                $new_message_thread_id = $db_model->getDb()->getLastId();
                //insert message to table
                $message_values = array('message_thread_id'=>$new_message_thread_id, 'user_id'=>$sender_id,
                    'sent'=>1, 'message_body'=>$message);
                $db_model->insert(MESSAGE_TABLE, $message_values);
            }
            redirect_to(PATH_TO_VIEWS . 'theirprofile.php?user_id=' . $_POST['user_id'] . '&message=' . MESSAGE_SENT_INDEX);
        } else {
            redirect_to(PATH_TO_VIEWS . 'theirprofile.php?user_id=' . $_POST['user_id'] . '&error=' . TEXT_AREA_EMPTY_INDEX);
        }
        
    } else {
        redirect_to(PATH_TO_VIEWS . 'home.php?error=2');
    }
}