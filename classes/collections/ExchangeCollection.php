<?php

/**
 * Created by PhpStorm.
 * User: adamkisala
 * Date: 08/05/2016
 * Time: 20:38
 */

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Model.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Database.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/constants/Constants.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/models/Exchange.php');



class ExchangeCollection
{
    /**
     * @var Model|null
     */
    private $db_model = null;
    /**
     * @var Database|null
     */
    private $db_connection = null;

    /**
     * WishListCollection constructor.
     */
    public function __construct(){
        $this->db_connection = Database::getInstance();
        $this->db_model = new Model($this->db_connection);
    }
    
    public function getExchangesByOfferor($user_id){
        return $this->db_model->read(EXCHANGE_TABLE, 'user_id_offeror', $user_id);
    }
    
    public function getExchangesByAcceptor($user_id){
        return $this->db_model->read(EXCHANGE_TABLE, 'user_id_acceptor', $user_id);
    }

    public static function getExchangeByItemAcceptor($item_id){
        $db_connection = Database::getInstance();
        $db_model = new Model($db_connection);
        return $db_model->readFirst(EXCHANGE_TABLE, 'item_id_acceptor', $item_id);
    }
    public static function getExchangeByItemOfferor($item_id){
        $db_connection = Database::getInstance();
        $db_model = new Model($db_connection);
        return $db_model->readFirst(EXCHANGE_TABLE, 'item_id_offeror', $item_id);
    }
    
    public static function getExchangesWithMessageThread($exchanges){
        $result = array();
        foreach ($exchanges as $exchange){
            if ($exchange['message_thread_id']!= null){
                $result[] = $exchange;
            }
        }
        return $result;
    }
}