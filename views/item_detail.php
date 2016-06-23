<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/helpers/functions.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/models/User.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/models/Item.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/controllers/ImageController.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/controllers/ErrorsController.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/collections/ItemsCollection.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/collections/WishListCollection.php');

updateSession();

if (isset($_SESSION["user_id"])) {
    $_user = User::__constructWithIdFromDB(urlencode($_SESSION["user_id"]));
    $is_logged_in = true;
} else {
    $_user = new User();
    $is_logged_in = false;
}

if (isset($_GET['item_id'])) {
    $item = Item::__constructWithIdFromDB(urldecode($_GET['item_id']));
    $item_owner = User::__constructWithIdFromDB($item->getUserId());

} else {
    redirect_to(PATH_TO_VIEWS . 'home.php');

    //in case we reach here avoid null
    $item = new Item();
    $item_owner = new User();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" href="../images/favicon.ico">
    <link rel="Bookmark" href="../images/favicon.ico">
    <title>SWOPE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" type="text/css" href="../css/item_detail_style.css" media="screen">
    <link rel="stylesheet" type="text/css" href="../css/jquery.jscrollpane.css" media="all"/>
    <link rel="stylesheet" href="../css/zlight.menu.css" media="screen">
    <link rel="stylesheet" href="../css/like_heart.css" media="screen">
    <script src="../js/jquery-1.9.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery.zlight.menu.1.0.min.js"></script>
    <script type="text/javascript" src="../js/content.js"></script>
    <link rel="stylesheet" href="../css/etalage.css">
    <script src="../js/jquery.etalage.min.js"></script>
    <script>
        jQuery(document).ready(function ($) {
            $('#etalage').etalage({
                thumb_image_width: 300,
                thumb_image_height: 400,
                source_image_width: 800,
                source_image_height: 1000,
                show_hint: true,
                click_callback: function (image_anchor, instance_id) {
                    alert('Callback example:\nYou clicked on an image with the anchor: "' + image_anchor + '"\n(in Etalage instance: "' + instance_id + '")');
                }
            });

        });
    </script>

</head>
<body>
<header>
    <?php
    if (isset($_GET["user_id"]) || (isset($_SESSION["user_id"]) && !empty($_SESSION["user_id"]))) include("share_page/header_logged_new.php");
    else include("share_page/header.php"); ?>
</header>
<div class="container" style="margin-top: 5%;">
    <div class="row" style="background-color:#fff;padding: 2%;">
        <div id="myphoto" class="col-lg-1 col-lg-offset-2 col-md-1 col-md-offset-2 col-sm-2  ">
            <a href="theirprofile.php?user_id=<?php echo $item->getUserId() ?>">
                <img
                    src="../classes/routers/image_router.php?image=<?php echo urlencode($item_owner->getProfilePic()) ?>"
                    width="50px" height="50px" style="-moz-border-radius: 50px;
-webkit-border-radius: 50px;border-radius: 50px;
	border:2px solid #ff8542;"/>
            </a>
        </div>
        <div class="col-lg-2">
            <p><strong><?php echo $item->getName() ?></strong>
            </p>
            <p><?php echo $item_owner->getName() ?> / <?php echo date('d/m/Y', strtotime($item->getDateTime())) ?></p>
        </div>
    </div>
    <div class="row" style="padding: 1% 0 4% 0;background-color:#fff;">
        <!--<div id="item_picture" class="col-lg-4 col-lg-offset-2 col-md-4 col-md-offset-2 col-sm-5  col-xs-6 ">
            <img
                src="../classes/routers/image_router.php?image=<?php /*echo urlencode($item->getPhotos() . $item->getPictures()[0]) */ ?>"
                width="100%" style="padding:2%;border:2px solid #BEBEBE;"/>
        </div>-->
        <?php
            $photos =  $item->getPictures();
        ?>
        <div id="item_picture"
             class="col-lg-4 col-lg-offset-2 col-md-5 col-md-offset-1 col-sm-6 col-sm-offset-0  col-xs-8 col-xs-offset-0 ">
            <div class="single_left">
                <div class="grid images_3_of_2">
                    <ul id="etalage">
                        <?php foreach ($photos as $photo) { ?>
                        <li>
                            <a href="">
                                <img class="etalage_thumb_image" src="../classes/routers/image_router.php?image=<?php echo urlencode($item->getPhotos() . $photo)?>" class="img-responsive"/>
                                <img class="etalage_source_image" src="../classes/routers/image_router.php?image=<?php echo urlencode($item->getPhotos() . $photo)?>"  class="img-responsive"
                                     title=""/>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>


        <div class="col-lg-4 col-md-5 col-sm-6 col-xs-12">
            <p>
                <?php
                echo $item->getDescription();
                ?>
            </p>
            <p style="font-size: 17px;">
                <span
                    class="label label-success"><?php echo strtolower($item->getItemCategoryName($item->getCategoryTypeId())) ?></span>
            </p>
            <p id="like_heart_container">
                <a class="like_heart" id="like_heart" href="#" style="font-size: 22px;"

                    <?php
                    if ($is_logged_in) { ?>
                    <?php
                    $wish_list = new WishListCollection();
                    $items_ids = $wish_list->getItemsIdsFromWishList($_user->getUserId());
                    $item_in_wish_list = false;
                    foreach ($items_ids as $item_) {
                        if ($item_['item_id'] == $item->getItemId()) $item_in_wish_list = true;
                    }
                    if ($item_in_wish_list) {
                    ?>

                   data-lightbox="template_showcase">
                    <i style="color: red;" class="glyphicon glyphicon-heart"
                       id="like_heart_icon"><?php echo $item->getLikes() ?></i>

                    <?php
                    }
                    ?>

                </a>
            </p>
            <?php if ($item_owner->getUserId() != $_user->getUserId()) {
                if ($item_in_wish_list) {
                    $btn_colour = 'btn-danger';
                } else {
                    $btn_colour = 'btn-default';
                }
                ?>
                <p style="margin-top: 10%;">
                    <a href="#" class="btn <?php echo $btn_colour ?>" id="add_wish_btn"
                       onclick="updateWishList(<?php echo $item->getItemId() ?>,<?php echo $_user->getUserId() ?>);"
                       role="button"><?php
                        if ($item_in_wish_list) echo 'Remove from my wish list';
                        else echo 'Add to my wish list';
                        ?><span style="color: red; font-size: 15px" class="glyphicon glyphicon-heart"></span></a>

                    <button class="btn btn-info" data-toggle="modal" data-target="#exchangeModal">Exchange
                    </button>
                <p class="text-success" id="QUE2"><font size="+1">What I would like in exchange : </font>
                </p>
                <p class="text-muted">
                    I want a book.</p>

            <?php } else { ?>
                <div>
                    <div class="edit" style="margin-top: 20%;">
                        <a href="edit_product.php?item_id=<?php echo $item->getItemId()?>">
                        <span style="font-size: 30px;" class="glyphicon glyphicon-edit"></span>
                        </a>
                    </div>

                </div>
            <?php } ?>

            <?php
            include("share_page/exchange.php"); ?>
            <?php
            }

            ?>
        </div>
        <script type="text/javascript" src="../js/add_wish_list_item_detail.js"></script>


    </div>
    <?php include('share_page/message_box.php') ?>

    <?php include('share_page/comments.php') ?>


</div>
<hr style="border-top: 2px solid #fff;">
<div class="container">

    <p style="font-size: 26px;" class="visible-lg visible-md">
        <strong style="font-family: Ave Fedan PERSONAL USE ONLY;color: #ee8a06;font-size: 36px; ">Related
            Products</strong>
    </p>

    <div class="row">
        <div class="product-desc col-lg-9 col-md-9 col-sm-8">
            <div class="product-img ">
                <img src="../images/cloth2.jpg" class="img-responsive " alt=""/>
            </div>
            <div class="prod1-desc">
                <h5>
                    <a class="product_link" href="#">Fashion cloth</a>
                </h5>
                <p class="product_descr">
                    Vivamus ante lorem, eleifend nec interdum non, ullamcorper et arcu. Class aptent taciti sociosqu ad
                    litora torquent per conubia nostra.
                </p>
            </div>

        </div>
        <div class="col-lg-3 col-md-3 col-sm-4">

            <button class="button1">
                <span>Put into the wish list</span>
            </button>
        </div>

    </div>
    <div class="row">
        <div class="product-desc col-lg-9 col-md-9 col-sm-8">
            <div class="product-img">
                <img src="../images/fashion.jpg" class="img-responsive " alt=""/>
            </div>
            <div class="prod1-desc">
                <h5>
                    <a class="product_link" href="#">Beauty</a>
                </h5>
                <p class="product_descr">
                    Vivamus ante lorem, eleifend nec interdum non, ullamcorper et arcu. Class aptent taciti sociosqu ad
                    litora torquent per conubia nostra, per inceptos himenaeos.
                </p>
            </div>

        </div>
        <div class="col-lg-3 col-md-3 col-sm-4">

            <button class="button1">
                <span>Put into the wish list</span>
            </button>
        </div>

    </div>

    <div class="row">
        <div class="product-desc col-lg-9 col-md-9 col-sm-8">
            <div class="product-img">
                <img src="../images/cloth1.jpg" class="img-responsive " alt=""/>
            </div>
            <div class="prod1-desc">
                <h5>
                    <a class="product_link" href="#">Formal cloth</a>
                </h5>
                <p class="product_descr">
                    Vivamus ante lorem, eleifend nec interdum non, ullamcorper et arcu. Class aptent taciti sociosqu ad
                    litora torquent per conubia nostra, per inceptos himenaeos.
                </p>
            </div>

        </div>
        <div class="col-lg-3 col-md-3 col-sm-4">

            <button class="button1">
                <span>Put into the wish list</span>
            </button>
        </div>

    </div>
    <a href="cate_items.php" style="padding: 5%;"><h4 class="text-right">More</h4></a>
</div>
<!-- footer begin -->
<footer id="footer" class="footer">
    <?php include("share_page/footer.html"); ?></footer>
</body>
</html>