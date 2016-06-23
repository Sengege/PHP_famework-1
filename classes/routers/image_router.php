<?php
/**
 * Created by PhpStorm.
 * User: adamkisala
 * Date: 03/05/2016
 * Time: 10:05
 */
header('Content-type: image/png');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/classes/controllers/ImageController.php');

if (isset($_GET['image'])){
    $image_path = ImageController::getImage(urldecode($_GET['image']));
    $image_file = basename(urldecode($_GET['image']));
    $imageFileType = pathinfo($image_file,PATHINFO_EXTENSION);
    $contents = file_get_contents($image_path);
    
    if ($imageFileType === 'png') header('Content-type: image/png');
    else if ($imageFileType === 'jpeg' || $imageFileType === 'jpg') header('Content-type: image/jpeg');
    else return;

    echo  $contents;
    
}
