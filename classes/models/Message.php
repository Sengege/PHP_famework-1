<?php

/**
 * Created by PhpStorm.
 * User: adamkisala
 * Date: 13/05/2016
 * Time: 11:54
 */

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Model.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Database.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/constants/Constants.php');

/**
 * Class Message
 */
class Message
{
    /**
     * @var null
     */
    private $message_sub_thread_id = null;

    /**
     * @return null
     */
    public function getMessageSubThreadId()
    {
        return $this->message_sub_thread_id;
    }

    /**
     * @param null $message_sub_thread_id
     */
    public function setMessageSubThreadId($message_sub_thread_id)
    {
        $this->message_sub_thread_id = $message_sub_thread_id;
    }

    /**
     * @var null
     */
    private $message_id = null;
    /**
     * @var null
     */
    private $message_thread_id = null;
    /**
     * @var null
     */
    private $message_type_id = null;
    /**
     * @var null
     */
    private $user_id = null;
    /**
     * @var null
     */
    private $attachment_id = null;
    /**
     * @var null
     */
    private $date_time = null;
    /**
     * @var bool
     */
    private $sent = false;
    /**
     * @var string
     */
    private $subject = '';

    /**
     * @return null
     */
    public function getMessageId()
    {
        return $this->message_id;
    }

    /**
     * @param null $message_id
     */
    public function setMessageId($message_id)
    {
        $this->message_id = $message_id;
    }

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
     * @return null
     */
    public function getMessageTypeId()
    {
        return $this->message_type_id;
    }

    /**
     * @param null $message_type_id
     */
    public function setMessageTypeId($message_type_id)
    {
        $this->message_type_id = $message_type_id;
    }

    /**
     * @return null
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param null $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return null
     */
    public function getAttachmentId()
    {
        return $this->attachment_id;
    }

    /**
     * @param null $attachment_id
     */
    public function setAttachmentId($attachment_id)
    {
        $this->attachment_id = $attachment_id;
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
     * @return boolean
     */
    public function isSent()
    {
        return $this->sent;
    }

    /**
     * @param boolean $sent
     */
    public function setSent($sent)
    {
        $this->sent = $sent;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @var string
     */
    private $body = '';

    
    /**
     * Item constructor.
     * @param $item_id
     */
    public function __construct(){

    }

    /**
     * @param $message_id
     * @return Message
     */
    public static function __constructWithIdFromDB($message_id){
        $instance = new self();
        $db_connection = Database::getInstance();
        $db_model = new Model($db_connection);
        $message = $db_model->readFirst(MESSAGE_TABLE, "message_id", (integer)$message_id);
        if ($message){
            $instance->message_id = $message['message_id'];
            $instance->message_thread_id = $message['message_thread_id'];
            $instance->message_type_id = $message['message_type_id'];
            $instance->user_id = $message['user_id'];
            $instance->attachment_id = $message['attachment_id'];
            $instance->date_time = $message['date_time'];
            $instance->sent = $message['sent'];
            $instance->subject = $message['subject'];
            $instance->body = $message['message_body'];
            $instance->message_sub_thread_id = $message['message_sub_thread_id'];
        }
        return $instance;
    }
}