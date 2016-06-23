<?php

/**
 * Created by PhpStorm.
 * User: adamkisala
 * Date: 02/05/2016
 * Time: 15:47
 */

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/classes/constants/Constants.php');

class ImageController
{
    public static $errors = [];
    public static $messages = [];
    
    public static function getAllImagesFromDir($dirname){
        if(!file_exists($dirname)) return [];
        $filepaths = array_diff(scandir($dirname), array('..', '.'));
        $result = [];
        foreach ($filepaths as $filepath){
            if ($filepath == '.' || $filepath == '..') continue;
            else $result[] = $filepath;
        }
        /*foreach (glob("{$dirname}*.png, {$dirname}*.jpeg, {$dirname}*.jpg", GLOB_ERR) as $filepath){
            $filepaths[] = $dirname . basename($filepath);
            ErrorsController::$errors[] = basename($filepath);
        }*/
        return $result;
    }

    public static function getImage($imageLocation, $file = false){
        if($file) return IMAGES_PATH . basename($imageLocation);
        else return IMAGES_PATH . $imageLocation;

    }

    public static function createImagesFolder($foldername){

        if(!(mkdir(IMAGES_PATH . basename($foldername), 0755))){
            ImageController::$errors[] = "Failed to create folder " . $foldername;
            return false;
        } else return true;
    }

    public static function createUniqueFolderName($id){
        return uniqid($id . '_');
    }
    
    public static function saveImage($foldername){
        $target_dir = IMAGES_PATH;
        $filename = basename($_FILES["fileToUpload"]["name"]);
        if(empty($filename)) return '';
        $unique_foldername = ImageController::createUniqueFolderName($foldername);
        if (!ImageController::createImagesFolder($unique_foldername)){
            //failed to create folder
            ImageController::$errors[] = "Failed to allocate space for picture.";
            return "";
        }
        $target_file = $target_dir . $unique_foldername . '/'. $filename;
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                ImageController::$messages[] =  "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                ImageController::$errors[] = "File is not an image.";
                $uploadOk = 0;
            }
        }
        // Check if file already exists
        if (file_exists($target_file)) {
            ImageController::$errors[] = "Sorry, file already exists.";
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["fileToUpload"]["size"] > MAX_IMAGE_SIZE) {
            ImageController::$errors[] = "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            ImageController::$errors[] = "Sorry, only JPG, JPEG and PNG files are allowed.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            ImageController::$errors[] = "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                ImageController::$messages[] =  "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
            } else {
                ImageController::$errors[] = "Sorry, there was an error uploading your file.";
            }
        }

        return $target_file = $unique_foldername . '/' . $filename;
    }
    
    public static function deleteImagesFolder($target){
        if(is_dir($target)){
            $files = glob( $target . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned

            foreach( $files as $file )
            {
                ImageController::deleteImagesFolder( $file );
            }

            rmdir( $target );
        } elseif(is_file($target)) {
            unlink( $target );
        }
    }
    
    public static function getItemFirstImage($path){
        $dir = IMAGES_PATH . $path . '/';
        $images = ImageController::getAllImagesFromDir($dir);
        if (count($images) > 0) {
            return $image = $images[0];
        } else {
            return $image = "";
        }
    }
    
}