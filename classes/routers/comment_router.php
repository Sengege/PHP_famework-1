<?php
/**
 * Created by PhpStorm.
 * User: adamkisala
 * Date: 16/05/2016
 * Time: 14:04
 */
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/helpers/functions.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Model.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Database.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/constants/Constants.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/controllers/Login.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/models/MessageThread.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/models/Message.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/collections/MessagesCollection.php');




$db_connection = Database::getInstance();
$db_model = new Model($db_connection);


if (isset($_SESSION['user_id'])){
    if (isset($_POST['submit']) || isset($_POST['submit_answer'])){
        $commentator_id = $_POST['commentator_id'];
        $item_id = $_POST['item_id'];
        $comment = $_POST['comment'];
        if ("" != trim($_POST['comment'])){
            //check if thread with that item id already exists
            $result = $db_model->readFirst(MESSAGE_THREAD_TABLE, 'item_id', $item_id);
            //die(print_r($result));
            //if message thread does exist
            if($result['message_thread_id'] != null && !empty($result['message_thread_id'])){

                //check if message sub_thread has been posted
                if (isset($_POST['submit_answer'])){
                    $first_message = Message::__constructWithIdFromDB($_POST['first_message']);
                    $sub_thread_messages_id = $first_message->getMessageSubThreadId();
                    //if sub thread does not exist yet
                    if ($sub_thread_messages_id == null || empty($sub_thread_messages_id)){
                        //create sub thread first
                        $sub_thread_item = array('item_id'=>$item_id);
                        //insert new message
                        $db_model->insert(MESSAGE_THREAD_TABLE, $sub_thread_item);
                        //update first message in a thread with sub thread id
                        //get last id
                        $sub_thread_last_id = $db_model->getDb()->getLastId();

                        $sub_thread_id_array = array('message_sub_thread_id'=>$sub_thread_last_id);
                        //update first message with sub thread id
                        $db_model->update(MESSAGE_TABLE, 'message_id', $first_message->getMessageId(), $sub_thread_id_array);
                    } else {
                        $sub_thread_last_id = $first_message->getMessageSubThreadId();
                    }

                }
                if (isset($sub_thread_last_id) && $sub_thread_last_id != null && !empty($sub_thread_last_id)){
                    $values = array('message_thread_id'=>$result['message_thread_id'], 'user_id'=>$commentator_id,
                        'sent'=>1, 'message_body'=>$comment, 'message_sub_thread_id'=>$sub_thread_last_id);
                } else {
                    $values = array('message_thread_id'=>$result['message_thread_id'], 'user_id'=>$commentator_id,
                        'sent'=>1, 'message_body'=>$comment);
                }
                $db_model->insert(MESSAGE_TABLE, $values);
            } else {
                $thread_values = array('item_id'=>$item_id);
                $db_model->insert(MESSAGE_THREAD_TABLE, $thread_values);
                $last_id = $db_model->getDb()->getLastId();

                $values = array('message_thread_id'=>$last_id, 'user_id'=>$commentator_id,
                    'sent'=>1, 'message_body'=>$comment);
                $db_model->insert(MESSAGE_TABLE, $values);
            }
            redirect_to(PATH_TO_VIEWS . 'item_detail.php?item_id=' . $item_id);
        } else {
            redirect_to(PATH_TO_VIEWS . 'item_detail.php?item_id=' . $item_id . '&error=4');
        }
        
    } else {
       redirect_to(PATH_TO_VIEWS . 'home.php?error=2');
    }
} else {
    $login = new Login();
    $login->doLogout();
    redirect_to(PATH_TO_VIEWS . 'home.php?error=1');
}