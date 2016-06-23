<?php
/**
 * Created by PhpStorm.
 * User: adamkisala
 * Date: 15/04/2016
 * Time: 12:35
 */
require_once '../helpers/functions.php';
require_once '../controllers/Registration.php';
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/controllers/Login.php');

if (isset($_GET["logout"])){
    $login = new Login();
    redirect_to(PATH_TO_VIEWS . "first_page.php");
} else {
    redirect_to(PATH_TO_VIEWS . "first_page.php");
}