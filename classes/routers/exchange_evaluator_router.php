<?php
/**
 * Created by PhpStorm.
 * User: adamkisala
 * Date: 08/05/2016
 * Time: 22:07
 */
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/helpers/functions.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Model.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Database.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/constants/Constants.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/controllers/Login.php');


$db_connection = Database::getInstance();
$db_model = new Model($db_connection);

if (isset($_SESSION['user_id'])){
    if (isset($_GET['cmd'])){
        $exchange = $_GET['exchange_id'];
        if ($_GET['cmd'] == 'decline'){
            $values = array('status_type_id'=>EXCHANGE_STATUS_DECLINED);
            $result = $db_model->update(EXCHANGE_TABLE, 'exchange_id', $exchange,  $values);
            redirect_to(PATH_TO_VIEWS . 'myprofile.php?active_tab=requests');
        } elseif ($_GET['cmd'] == 'accept'){
            $values = array('status_type_id'=>EXCHANGE_STATUS_ACCEPTED);
            $result = $db_model->update(EXCHANGE_TABLE, 'exchange_id', $exchange,  $values);
            //TODO redirect to evaluate exchange page
            redirect_to(PATH_TO_VIEWS . 'myprofile.php?active_tab=requests');
        } elseif($_GET['cmd'] == 'delete'){
            $result = $db_model->delete(EXCHANGE_TABLE, 'exchange_id', $exchange);
            if ($result) redirect_to(PATH_TO_VIEWS . 'myprofile.php?active_tab=requests');
            else {
                //TODO show DB errors

            }
        } elseif ($_GET['cmd'] == 'confirm'){
            $values = array('status_type_id'=>EXCHANGE_STATUS_COMPLETED);
            $result = $db_model->update(EXCHANGE_TABLE, 'exchange_id', $exchange,  $values);
            redirect_to(PATH_TO_VIEWS . 'myprofile.php?active_tab=requests');
        } elseif ($_GET['cmd'] == 'message'){
            //TODO messages
            redirect_to(PATH_TO_VIEWS . 'myprofile.php?active_tab=requests');
        } elseif ($_GET['cmd'] == 'offer'){
            $values = array('status_type_id'=>EXCHANGE_STATUS_OFFERED);
            $result = $db_model->update(EXCHANGE_TABLE, 'exchange_id', $exchange,  $values);
            redirect_to(PATH_TO_VIEWS . 'myprofile.php?active_tab=requests');
        }
    }
} else {
    $login = new Login();
    $login->doLogout();
    //$_SESSION['errors'] = "You have been logged out!";
    redirect_to(PATH_TO_VIEWS . 'home.php?error=1');
}
