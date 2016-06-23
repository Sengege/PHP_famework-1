<?php

/**
 * Created by PhpStorm.
 * User: adamkisala
 * Date: 13/05/2016
 * Time: 12:30
 */

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Model.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Database.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/constants/Constants.php');


/**
 * Class MessageThread
 */
class MessageThread
{

    private $sender_id = null;
    private $receiver_id = null;
    /**
     * @var null
     */
    private $message_thread_id = null;

    /**
     * @return null
     */
    public function getMessageThreadId()
    {
        return $this->message_thread_id;
    }

    /**
     * @param null $message_thread_id
     */
    public function setMessageThreadId($message_thread_id)
    {
        $this->message_thread_id = $message_thread_id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return null
     */
    public function getDateTime()
    {
        return $this->date_time;
    }

    /**
     * @param null $date_time
     */
    public function setDateTime($date_time)
    {
        $this->date_time = $date_time;
    }

    /**
     * @return null
     */
    public function getItemId()
    {
        return $this->item_id;
    }

    /**
     * @param null $item_id
     */
    public function setItemId($item_id)
    {
        $this->item_id = $item_id;
    }

    /**
     * @var string
     */
    private $title = '';
    /**
     * @var null
     */
    private $date_time = null;
    /**
     * @var null
     */
    private $item_id = null;

    /**
     * MessageThread constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param $message_thread_id
     * @return MessageThread
     */
    public static function __constructWithIdFromDB($message_thread_id){
        $instance = new self();
        $db_connection = Database::getInstance();
        $db_model = new Model($db_connection);
        $message_thread = $db_model->readFirst(MESSAGE_THREAD_TABLE, "message_thread_id", (integer)$message_thread_id);
        if ($message_thread){
            $instance->message_thread_id = $message_thread['message_thread_id'];
            $instance->title = $message_thread['title'];
            $instance->item_id = $message_thread['item_id'];
            $instance->date_time = $message_thread['date_time'];
            $instance->sender_id = $message_thread['sender_id'];
            $instance->receiver_id = $message_thread['receiver_id'];
        }
        return $instance;
    }
    
    public static function getMessageThreadByItemId($item_id){
        $db_connection = Database::getInstance();
        $db_model = new Model($db_connection);
        $result = $db_model->readFirst(MESSAGE_THREAD_TABLE, 'item_id', $item_id);
        if ($result){
            return MessageThread::__constructWithIdFromDB($result['message_thread_id']);
        } else return new MessageThread();
    }

    /**
     * @return null
     */
    public function getReceiverId()
    {
        return $this->receiver_id;
    }

    /**
     * @param null $receiver_id
     */
    public function setReceiverId($receiver_id)
    {
        $this->receiver_id = $receiver_id;
    }

    /**
     * @return null
     */
    public function getSenderId()
    {
        return $this->sender_id;
    }

    /**
     * @param null $sender_id
     */
    public function setSenderId($sender_id)
    {
        $this->sender_id = $sender_id;
    }
}