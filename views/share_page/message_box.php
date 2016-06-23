<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/controllers/ErrorsController.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/controllers/InfoMessageController.php');

if (isset($_GET['error'])) {
    $error = ErrorsController::getError($_GET['error']);
    ?>
    <div class="alert alert-danger fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Error!</strong> <?php echo " " . $error ?>
    </div>
    <?php
}
if (isset($_GET['message'])) {
    $info_message = InfoMessageController::getMessage($_GET['message']); ?>

    <div class="alert alert-success fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Success!</strong> <?php echo " " . $info_message ?>
    </div>

    <?php
}
?>