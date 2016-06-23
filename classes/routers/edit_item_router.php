<?php
/**
 * Created by PhpStorm.
 * User: adamkisala
 * Date: 31/05/2016
 * Time: 08:49
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

if (isset($_SESSION['user_id'])){
    if (isset($_POST['submit'])) {
        $item_id = $_POST['item_id'];
        $title = $_POST['title'];

        $item = Item::__constructWithIdFromDB($item_id);

        if (isset($_FILES['images']) && $_FILES['images']['error'] != 4) {
            $target_dir = IMAGES_PATH;
            $unique_foldername = ImageController::createUniqueFolderName($item->getUserId());
            $all_uploaded = true;

            if (!ImageController::createImagesFolder($unique_foldername)) {
                //failed to create folder
                redirect_to(PATH_TO_VIEWS . 'edit_product.php?error=' . SERVER_PICTURE_FOLDER_ERROR_INDEX);
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

                    } else {
                        $all_uploaded = false;
                    }
                }
            }

            if ($all_uploaded) {
                //ImageController::deleteImagesFolder($item->getPhotos());
                $item->setPhotos($unique_foldername . '/');
            }
        }

        //set title and description and status accordingly
        if (isset($_POST['title']) && !empty($_POST['title'])) {
            $item->setName($_POST['title']);
        }
        if (isset($_POST['description']) && !empty($_POST['description'])) {
            $item->setDescription($_POST['description']);
        }
        if (isset($_POST['category']) && !empty($_POST['category'])) {
            $item->setCategoryTypeId($item->getItemCatIdByName($_POST['category']));
        }
        if (isset($_POST['subcategory']) && !empty($_POST['subcategory'])) {
            $item->setSubCategoryId($item->getItemSubCatIdByName($_POST['subcategory']));
        }
        if (isset($_POST['wanted']) && !empty($_POST['wanted'])) {
            $item->setWanted($_POST['wanted']);
        }
        if (isset($_POST['value']) && !empty($_POST['value'])) {
            $item->setValue($_POST['value']);
        }
        if (isset($_POST['my_category']) && !empty($_POST['my_category'])) {
            $item->setMyCategory($_POST['my_category']);
        }

        //insert into DB
        $values = array('category_type_id' => $item->getCategoryTypeId(), 'value_type_id' => $item->getValueTypeId(), 'name' => $item->getName(),
            'description' => $item->getDescription(), 'photos' => $item->getPhotos(), 'status_type_id' => $item->getStatusTypeId(), 'sub_category_type_id' => $item->getSubCategoryId(),
            'wanted' => $item->getWanted(), 'value'=>$item->getValue(), 'my_category'=>$item->getMyCategory());
        $db_model->update(ITEMS_TABLE, 'item_id', $item->getItemId(), $values);
        redirect_to(PATH_TO_VIEWS . 'item_detail.php?item_id=' . $item->getItemId() . '&message=' . MESSAGE_DETAILS_UPDATED_INDEX);

    } else {
        redirect_to(PATH_TO_VIEWS . 'home.php?error=' . GENERIC_ERROR_INDEX);
    }
} else {
    redirect_to(PATH_TO_VIEWS . 'home.php?error=' . GENERIC_ERROR_INDEX);
}

