<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 23/03/2016
 * Time: 23:34
 */

require_once '../helpers/functions.php';
require_once '../controllers/Registration.php';

    if(isset($_POST["submitEN"])){
        $registration = new Registration();
        if($registration->registration_successful){
            redirect_to(PATH_TO_VIEWS . 'confirm_page_english.php');
        } else {
            //die(print_r($registration->errors));
            redirect_to(PATH_TO_VIEWS . 'register.php?error=' . GENERIC_ERROR_INDEX);
        }
    } else if (isset($_POST["submitCN"])){
        $registration = new Registration();
        if($registration->registration_successful){
            redirect_to(PATH_TO_VIEWS . 'confirm_page_chinese.php');
        } else {
            //echo print_r($registration->errors);
            redirect_to(PATH_TO_VIEWS . 'register.php?error=' . GENERIC_ERROR_INDEX);
        }
    } else {
        //TODO do something with the when invalid submit?
        
    }


