<?php
/**
 * Created by PhpStorm.
 * User: adamkisala
 * Date: 25/05/2016
 * Time: 18:17
 */

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/helpers/functions.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Model.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Database.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/constants/Constants.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/models/User.php');

if (isset($_SESSION['user_id'])) {
    if (isset($_POST['submit'])) {
        $db_connection = Database::getInstance();
        $db_model = new Model($db_connection);

        $user_id = $_POST['user_id'];
        $exchange_id = $_POST['exchange_id'];
        $description = $_POST['description'];
        $evaluation =  $_POST['evaluation'];
        $reviewer_id = $_POST['reviewer_id'];

        //update user's dislikes and likes
        if ($evaluation === THUMBS_DOWN){
            $u = User::__constructWithIdFromDB($user_id);
            $dislikes = $u->getDislikes() + 1;
            $values = array('dislikes'=>$dislikes);
            $db_model->update(USERS_TABLE, 'user_id', $user_id, $values);
            $evaluation = THUMBS_DOWN;
        } else {
            $u = User::__constructWithIdFromDB($user_id);
            $likes = $u->getLikes() + 1;
            $values = array('likes'=>$likes);
            $db_model->update(USERS_TABLE, 'user_id', $user_id, $values);
            $evaluation = THUMBS_UP;
        }

        //get exchange and change status
        //$values = array('status_type_id'=>EXCHANGE_STATUS_EVALUATED);
        //$db_model->update(EXCHANGE_TABLE, 'exchange_id', $exchange_id, $values);

        //insert data into db
        $values = array('user_id'=>$user_id, 'exchange_id'=>$exchange_id, 'description'=>$description, 'evaluation'=>$evaluation,
            'reviewer_id'=>$reviewer_id);
        $db_model->insert(REVIEWS_TABLE, $values);
        
        redirect_to(PATH_TO_VIEWS . 'myprofile.php?message=' . MESSAGE_SENT_INDEX . '&active_tab=requests');
    }
} else {
    redirect_to(PATH_TO_VIEWS . 'home.php?error=2');
}