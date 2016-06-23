<?php

/**
 * Created by PhpStorm.
 * User: adamkisala
 * Date: 13/05/2016
 * Time: 12:03
 */

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Model.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Database.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/constants/Constants.php');

class MessagesCollection
{

    /**
     * WishListCollection constructor.
     */
    public function __construct(){

    }

    public static function getMessagesByThreadIdNewestFirst($message_thread_id){
        if($message_thread_id){
            $db_connection = Database::getInstance();
            $db_model = new Model($db_connection);
            return $db_model->read(MESSAGE_TABLE, 'message_thread_id', $message_thread_id, false, ' ORDER BY date_time DESC ');
        } else {
            return array();
        }
    }

    public static function getMessagesByThreadIdOldestFirst($message_thread_id){
        if($message_thread_id){
            $db_connection = Database::getInstance();
            $db_model = new Model($db_connection);
            return $db_model->read(MESSAGE_TABLE, 'message_thread_id', $message_thread_id, false, ' ORDER BY date_time ASC ');
        } else {
            return array();
        }
    }

    public static function getSubMessagesByThreadIdOldestFirst($message_thread_id){
        if($message_thread_id){
            $db_connection = Database::getInstance();
            $db_model = new Model($db_connection);
            return $db_model->read(MESSAGE_TABLE, 'message_sub_thread_id', $message_thread_id, false, ' ORDER BY date_time ASC ');
        } else {
            return array();
        }
    }

    public static function getDirectMessagesThreadsByUserAsSenderOldestFirst($user_id){
        $db_connection = Database::getInstance();
        $db_model = new Model($db_connection);
        
        return $db_model->read(MESSAGE_THREAD_TABLE, 'sender_id', $user_id, false, ' ORDER BY date_time ASC ');
    }

    public static function getDirectMessagesThreadsByUserAsReceiverOldestFirst($user_id){
        $db_connection = Database::getInstance();
        $db_model = new Model($db_connection);

        return $db_model->read(MESSAGE_THREAD_TABLE, 'receiver_id', $user_id, false, ' ORDER BY date_time ASC ');
    }
    
    public static function getDirectMessagesByTwoUsersOldestFirst($sender_id, $receiver_id){
        $db_connection = Database::getInstance();
        $db_model = new Model($db_connection);
        $message_thread = $db_model->readTwoKeys(MESSAGE_THREAD_TABLE, 'sender_id', $sender_id, 'receiver_id', $receiver_id);
        if (count($message_thread)<= 0 || $message_thread[0]['message_thread_id'] == null || empty($message_thread[0]['message_thread_id'])){
            $message_thread = $db_model->readTwoKeys(MESSAGE_THREAD_TABLE, 'sender_id', $receiver_id, 'receiver_id', $sender_id);
        }
        if ($message_thread[0]['message_thread_id'] != null || !empty($message_thread[0]['message_thread_id'])){
            return $db_model->read(MESSAGE_TABLE, 'message_thread_id', $message_thread[0]['message_thread_id'], false, ' ORDER BY date_time ASC ');
        } else {
            return array();
        }

    }

}