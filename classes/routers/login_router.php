<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 29/03/2016
 * Time: 10:37
 */
//TODO check if user has registered or not

require_once '../helpers/functions.php';
require_once '../controllers/Registration.php';
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/controllers/Login.php');


if(isset($_POST["loginEN"])){
    $login = new Login();
    if($login->isUserLoggedIn()){
        registerUserForSession($login->getUserId());
        redirect_to(PATH_TO_VIEWS . "first_page.php");
    } else {
        redirect_to(PATH_TO_VIEWS . "login.php?error=3");
    }
} else if (isset($_POST["loginCN"])){
    $login = new Login();
    if($login->isUserLoggedIn()){
        registerUserForSession($login->getUserId());
        redirect_to(PATH_TO_VIEWS . "first_page.php");
    } else {
        redirect_to(PATH_TO_VIEWS . "login.php?error=3");
    }
} else {
    //TODO do something with the when invalid submit?
    echo "No submit";
}