<?php
/**
 * Created by PhpStorm.
 * User: adamkisala
 * Date: 15/04/2016
 * Time: 03:27
 */


require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/helpers/functions.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/models/User.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Model.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Database.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/constants/Constants.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/controllers/ImageController.php');

$db_connection = Database::getInstance();
$db_model = new Model($db_connection);

if(isset($_POST["submit"])){
    $user = new User();
    $user->setUserId($_POST['user_id']);
    $user->setEmail($_POST['email']);
    $user->setLocation($_POST['location']);
    $user->setUniversity($_POST['university']);
    $user->setContactNo($_POST['contact_no']);
    $user->setDescription($_POST['user_description']);

    if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] != 4){
        //check if profile picture already exists
        $db_user = $db_model->readFirst(USERS_TABLE, 'user_id', $user->getUserId());
        $profile_pic = $db_user['profile_pic'];
        if($profile_pic != null || !empty($profile_pic)){
            //delete old user pic folder
            ImageController::deleteImagesFolder(IMAGES_PATH . dirname($profile_pic). '/');
        }
        $user->setProfilePic(ImageController::saveImage($user->getUserId()));
        if (count(ImageController::$errors) > 0) {
            redirect_to(PATH_TO_VIEWS . 'myprofile.php?error=1');
        }
        $values = array('email'=> $user->getEmail(), 'location' => $user->getLocation(), 'university' => $user->getUniversity(), 'contact_no' => (int)$user->getContactNo(), 'description' => $user->getDescription(),
            'profile_pic'=>$user->getProfilePic());
    } else {
        $values = array('email'=> $user->getEmail(), 'location' => $user->getLocation(), 'university' => $user->getUniversity(), 'contact_no' => (int)$user->getContactNo(), 'description' => $user->getDescription());
    }

    $db_model->update(USERS_TABLE, 'user_id', (int)$user->getUserId(), $values);

    redirect_to(PATH_TO_VIEWS . "myprofile.php?user_id=" . $user->getUserId() . "&message=1");

} else {
    redirect_to(PATH_TO_VIEWS . "home.php?error=1");
}

