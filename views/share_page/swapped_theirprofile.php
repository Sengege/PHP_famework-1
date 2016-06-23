<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/controllers/ImageController.php');
?>
<div class="row">

    <div id="myprofile_request"
         class="col-lg-2 col-lg-offset-0 col-md-2 col-md-offset-0  col-sm-3 col-sm-offset-2 col-xs-4">

        <img
            src="../classes/routers/image_router.php?image=<?php echo urlencode($offeror_item->getPhotos() . ImageController::getItemFirstImage($offeror_item->getPhotos())) ?>"
            style="width:90%" class="gray">
        <a href="theirprofile.php?user_id=<?php echo $offeror->getUserId() ?>">
            <img class="img-person"
                 src="../classes/routers/image_router.php?image=<?php echo urlencode($offeror->getProfilePic()) ?>"/>
        </a>
        <p><strong
                style="color: #000;text-align: center;"><?php echo $offeror_item->getName() ?></strong>
        </p>
        <!-- items name -->
        <p>By: <?php echo $offeror->getName() ?></p>
    </div>
    <div
        class="col-lg-2 col-lg-offset-0 col-md-2 col-md-offset-0 col-sm-3 col-sm-offset-0 col-xs-4">

        <img src="../images/exch.png" style="width:60%;margin-top: 10%">
    </div>

    <div id="myprofile_request"
         class="col-lg-2 col-lg-offset-0 col-md-2 col-md-offset-0 col-sm-3 col-sm-offset-0 col-xs-4 col-xs-offset-0">

        <img
            src="../classes/routers/image_router.php?image=<?php echo urlencode($acceptor_item->getPhotos() . ImageController::getItemFirstImage($acceptor_item->getPhotos())) ?>"
            style="width:90%;" class="gray">
        <a href="theirprofile.php?user_id=<?php echo $acceptor->getUserId() ?>">
            <img class="img-person"
                 src="../classes/routers/image_router.php?image=<?php echo urlencode($acceptor->getProfilePic()) ?>"/>
        </a>
        <p><strong
                style="color: #000;text-align: center;"><?php echo $acceptor_item->getName() ?></strong>
        </p>
        <!-- items name -->
        <p>By: <?php echo $acceptor->getName() ?></p>
    </div>
</div>

<hr/>