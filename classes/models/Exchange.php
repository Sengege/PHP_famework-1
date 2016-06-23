<?php

/**
 * Created by PhpStorm.
 * User: adamkisala
 * Date: 08/05/2016
 * Time: 20:50
 */

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Model.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Database.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/constants/Constants.php');

class Exchange
{
    private $message_thread_id = null;
    private $exchange_id = null;
    private $user_id_offeror = null;
    private $user_id_acceptor = null;
    private $item_id_offeror = null;
    private $item_id_acceptor = null;
    private $status_type_id = null;
    private $description = '';

    public function __construct(){

    }

    public static function __constructWithIdFromDB($exchange_id){
        $instance = new self();
        $db_connection = Database::getInstance();
        $db_model = new Model($db_connection);
        $exchange = $db_model->readFirst(EXCHANGE_TABLE, "exchange_id", $exchange_id);
        if ($exchange){
            $instance->exchange_id = $exchange["exchange_id"];
            $instance->user_id_acceptor = $exchange["user_id_acceptor"];
            $instance->user_id_offeror = $exchange["user_id_offeror"];
            $instance->item_id_acceptor = $exchange["item_id_acceptor"];
            $instance->item_id_offeror = $exchange["item_id_offeror"];
            $instance->status_type_id = $exchange["status_type_id"];
            $instance->description = $exchange["description"];
            $instance->message_thread_id = $exchange['message_thread_id'];
        }
        return $instance;
    }

    /**
     * @return null
     */
    public function getExchangeId()
    {
        return $this->exchange_id;
    }

    /**
     * @param null $exchange_id
     */
    public function setExchangeId($exchange_id)
    {
        $this->exchange_id = $exchange_id;
    }

    /**
     * @return null
     */
    public function getUserIdOfferor()
    {
        return $this->user_id_offeror;
    }

    /**
     * @param null $user_id_offeror
     */
    public function setUserIdOfferor($user_id_offeror)
    {
        $this->user_id_offeror = $user_id_offeror;
    }

    /**
     * @return null
     */
    public function getUserIdAcceptor()
    {
        return $this->user_id_acceptor;
    }

    /**
     * @param null $user_id_acceptor
     */
    public function setUserIdAcceptor($user_id_acceptor)
    {
        $this->user_id_acceptor = $user_id_acceptor;
    }

    /**
     * @return null
     */
    public function getItemIdOfferor()
    {
        return $this->item_id_offeror;
    }

    /**
     * @param null $item_id_offeror
     */
    public function setItemIdOfferor($item_id_offeror)
    {
        $this->item_id_offeror = $item_id_offeror;
    }

    /**
     * @return null
     */
    public function getItemIdAcceptor()
    {
        return $this->item_id_acceptor;
    }

    /**
     * @param null $item_id_acceptor
     */
    public function setItemIdAcceptor($item_id_acceptor)
    {
        $this->item_id_acceptor = $item_id_acceptor;
    }

    /**
     * @return null
     */
    public function getStatusTypeId()
    {
        return $this->status_type_id;
    }

    /**
     * @param null $status_type_id
     */
    public function setStatusTypeId($status_type_id)
    {
        $this->status_type_id = $status_type_id;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
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
}