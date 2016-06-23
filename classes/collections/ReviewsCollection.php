<?php

/**
 * Created by PhpStorm.
 * User: adamkisala
 * Date: 25/05/2016
 * Time: 18:14
 */

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Model.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Database.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/constants/Constants.php');

class ReviewsCollection
{

    public static function getReviewsByUserIdNewestFirst($user_id){
        $db_connection = Database::getInstance();
        $db_model = new Model($db_connection);
        return $db_model->read(REVIEWS_TABLE, 'user_id', $user_id, false, ' ORDER BY date_time DESC ');
    }
    
    public static function getReviewsByExchangeId($exchange_id){
        $db_connection = Database::getInstance();
        $db_model = new Model($db_connection);
        return $db_model->read(REVIEWS_TABLE, 'exchange_id', $exchange_id);
    }
}