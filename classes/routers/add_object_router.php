<?php
/**
 * Created by PhpStorm.
 * User: adamkisala
 * Date: 03/05/2016
 * Time: 23:07
 */
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/models/Item.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/helpers/functions.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/models/User.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Model.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Database.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/constants/Constants.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/controllers/ImageController.php');

updateSession();
$db_connection = Database::getInstance();
$db_model = new Model($db_connection);

if (isset($_POST['submit'])) {
    $item = new Item();
    $all_info_provided = true;
    $user_id = (isset($_SESSION['user_id'])) ? $_SESSION['user_id'] : -1;

    if ($user_id < 0) return;

    if (isset($_FILES['images'])) {
        $target_dir = IMAGES_PATH;
        $unique_foldername = ImageController::createUniqueFolderName($user_id);
        $all_uploaded = true;

        if (!ImageController::createImagesFolder($unique_foldername)) {
            //failed to create folder
            ImageController::$errors[] = "Failed to allocate space for picture.";
        }

        $total_files = count($_FILES['images']['name']);
        $response = ['code' => 'OK'];

        for ($i = 0; $i < $total_files; $i++) {
            //Get the temp file path
            $tmpFilePath = $_FILES['images']['tmp_name'][$i];

            //Make sure we have a filepath
            if ($tmpFilePath != "") {

                //Setup our new file path
                $newFilePath = IMAGES_PATH . $unique_foldername . '/' . $_FILES['images']['name'][$i];

                //Upload the file into the temp dir
                if (move_uploaded_file($tmpFilePath, $newFilePath)) {

                    echo print_r($response);

                } else {
                    $all_uploaded = false;
                }
            }
        }

        if ($all_uploaded) {
            $item->setPhotos($unique_foldername . '/');
            echo '<br>' . $item->getPhotos() . '<br>';
        }
    }
    //set title and description and status accordingly
    if (isset($_POST['title']) && !empty($_POST['title'])) {
        $item->setName($_POST['title']);
    } else $all_info_provided = false;
    if (isset($_POST['description']) && !empty($_POST['description'])) {
        $item->setDescription($_POST['description']);
    } else $all_info_provided = false;

    //get status from ID from DB
    $status = -1;
    if ($all_info_provided) {
        $status_row = $db_model->readFirst(ITEM_STATUS_TABLE, 'item_status', LIVE);
        $status = $status_row['status_type_id'];
        $item->setStatusTypeId($status);
    } else {
        $status_row = $db_model->readFirst(ITEM_STATUS_TABLE, 'item_status', NOT_FINISHED);
        $status = $status_row['status_type_id'];
        $item->setStatusTypeId($status);
    }

    //set category id
    if (isset($_POST['category_type'])) {
        $category_value = $_POST['category_type'];
        $category_row = $db_model->readFirst(ITEM_CATEGORY_TABLE, 'category_name', $category_value);
        $category_type_id = $category_row['category_type_id'];
        $item->setCategoryTypeId($category_type_id);
    } else $item->setCategoryTypeId(DEFAULT_CATEGORY_TYPE);

    //set value id
    if (isset($_POST['value_type'])) {
        $value_type_value = $_POST['value_type'];
        $value_row = $db_model->readFirst(ITEM_VALUE_TABLE, 'value_name', $value_type_value);
        $value_type_id = $value_row['value_type_id'];
        $item->setValueTypeId($value_type_id);
    } else $item->setValueTypeId(DEFAULT_ITEM_VALUE_TYPE);

    //set sub category value
    if (isset($_POST['sub_category_type_id'])) {
        $sub_category_value = $_POST['sub_category_type_id'];
        $sub_category_row = $db_model->readFirst(ITEM_SUB_CATEGORY_TABLE, 'sub_category_name', strtoupper($sub_category_value));
        $sub_category_item_id = $sub_category_row['sub_category_type_id'];
        $item->setSubCategoryId($sub_category_item_id);
    } else if ($item->getCategoryTypeId() == CAT_TYPE_ITEM) {
        $item->setSubCategoryId(SUB_CAT_ITEM_OTHER);
    } else if ($item->getCategoryTypeId() == CAT_TYPE_SKILL) {
        $item->setSubCategoryId(SUB_CAT_SKILL_OTHER);
    } else if ($item->getCategoryTypeId() == CAT_TYPE_EXPERIENCE) {
        $item->setSubCategoryId(SUB_CAT_EXP_OTHER);
    } else {
        $item->setSubCategoryId(null);
    }


    //insert into DB
    $values = array('user_id' => $user_id, 'category_type_id' => $item->getCategoryTypeId(), 'value_type_id' => $item->getValueTypeId(), 'name' => $item->getName(),
        'description' => $item->getDescription(), 'photos' => $item->getPhotos(), 'status_type_id' => $item->getStatusTypeId(), 'sub_category_type_id' => $item->getSubCategoryId());

    if (!$db_model->insert(ITEMS_TABLE, $values)) {
        $_SESSION['errors'] = "Could not create item";
        redirect_to(PATH_TO_VIEWS . 'myprofile.php');
    } else {
        redirect_to(PATH_TO_VIEWS . 'myprofile.php');
    }
}
