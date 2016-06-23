<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/helpers/functions.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/models/User.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/models/Item.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/models/Exchange.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/controllers/ImageController.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/controllers/ErrorsController.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/collections/ItemsCollection.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/collections/SkillsCollection.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/collections/ExchangeCollection.php');


updateSession();

if (isset($_GET["user_id"])) {
    $user = User::__constructWithIdFromDB(urldecode($_GET["user_id"]));
} else {
    redirect_to("home.php");
    //in case redirect doesn't work I don't want page to crush by calling methods on null object
    $user = new User();
}
$items_collection = new ItemsCollection();
$items = $items_collection->getItemsByUserId($user->getUserId());
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
    <link rel="stylesheet" type="text/css" href="../css/profile_style.css" media="screen">
    <script src="../js/jquery-1.9.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../css/zlight.menu.css" media="screen">
    <script src="../js/jquery.zlight.menu.1.0.min.js"></script>
    <script type="text/javascript" src="../js/content.js"></script>
    <script src='../js/imagesLoaded.js'></script>
    <script type="text/javascript" src="../js/masonry.pkgd.min.js"></script>
</head>
<body style="background-color: #F2F2EE;">
<header>
    <?php
    if ((isset($_SESSION["user_id"]) && !empty($_SESSION["user_id"]))) include("share_page/header_logged_new.php");
    else include("share_page/header.php"); ?>
    <div class="container">
        <div class="row" style="background-color: #fff;margin-top: 7%;">
            <div id="myprofile" class="col-lg-3 col-lg-offset-0 col-md-3 col-sm-4  col-xs-12">
                <div class="userphoto">

                    <img src="../classes/routers/image_router.php?image=<?php echo urlencode($user->getProfilePic()) ?>"
                         alt="userphoto" width="100%" style="border:solid #fff 5px;border-radius:10%;-moz-border-radius: 10%;
-webkit-border-radius: 10%;margin-top: -15%;"></div>
            </div>

            <div  class=" col-lg-6 col-lg-offset-0 col-md-6 col-md-offset-0 col-sm-5 col-sm-offset-0 col-xs-10 col-xs-offset-0">
                <div class="username" style="margin-top: 10px;font-style:italic;font-weight:bold;">
					<span><?php echo $user->getName() ?></span>

                    <?php
                    $skills = new SkillsCollection();
                    $user_skills = $skills->getUserSkills($user->getUserId());
                    $counter = 1;
                    foreach ($user_skills as $skill) {
                        $s = $skills->getSkillById($skill['skill_id']);
                        echo '<span class=\'label' . ' ';
                        if ($counter % 2 == 0) echo 'label-success\'>' . $s['skill_name'] . '</span><br>';
                        else echo 'label-warning\'>' . $s['skill_name'] . '</span> ';
                        $counter++;
                    }
                    ?>
                    <p style="margin-top: 5px;">
                        <a>
                            <span class='glyphicon glyphicon-thumbs-up'><?php echo htmlentities($user->getLikes()) ?></span>
                        </a>
                        <a>
                            <span class='glyphicon glyphicon-thumbs-down'><?php echo $user->getDislikes() ?></span>
                        </a>
                    </p>
                </div>
            </div>

            <?php if (isset($_SESSION['user_id'])) { ?>

                <div  class="col-lg-offset-1 col-lg-2 col-md-2 col-md-offset-1 col-sm-2 col-sm-offset-1 col-xs-2"  >
                    <div class="send_messages" style="margin-top: 20%;">

                        <button type="button" class="btn btn-default btn-sm" data-toggle="modal"
                                data-target="#send_messages_Modal">
                            <span class="glyphicon glyphicon-envelope"></span>
                        </button>
                        
                        <div class="modal fade" id="send_messages_Modal" tabindex="-1" role="dialog"
                             aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close"
                                                data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel">
                                            Send message to
                                            <span class="with-user-name"><?php echo $user->getName() ?></span>
                                        </h4>
                                        <!--  name. -->
                                    </div>
                                    <div class="modal-body container">
                                        <form role="form" method="post"
                                              action="../classes/routers/send_message_router.php">
                                            <div class="form-group row">
                                                <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6">
                                                    <textarea id="send_message" class="form-control" name="message"
                                                              rows="2"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-xs-6 col-sm-3 col-md-3 col-lg-2">
                                                    <button type="submit" class="form-control btn btn-danger"
                                                            name="submit"
                                                            value="submit">submit
                                                </div>
                                            </div>
                                            <input type="hidden" name="user_id"
                                                   value="<?php echo $user->getUserId() ?>">
                                            <input type="hidden" name="sender_id"
                                                   value="<?php echo $_SESSION['user_id'] ?>">
                                        </form>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal -->
                        </div>
                        <script>
                            $(".send_messages").click(function () {
                                $('.popover-show').popover('hide');
                            });
                        </script>
                    </div>
                </div>
                
            <?php } ?>
            <div class="col-lg-12 col-md-12 col-md-offset-0 col-sm-12 col-xs-12">
                <div class="introduce" style="margin-top: 1%; ">
                    <p class="introduction"
                       style="border: none; color:#BEBEBE;"><?php echo $user->getDescription() ?></p>
                </div>
            </div>

            <div class="col-lg-12 col-md-12 col-md-offset-0 col-sm-12 col-xs-12">
                <?php include('share_page/message_box.php'); ?>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="container main-container">
                    <div role="tabpanel">

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#items" aria-controls="items" role="tab" data-toggle="tab">ITEMS</a>
                            </li>
                            <li role="presentation">
                                <a href="#skills" aria-controls="skills" role="tab" data-toggle="tab">SKILLS</a>
                            </li>
                            <li role="presentation">
                                <a href="#experiences" aria-controls="experiences" role="tab" data-toggle="tab">EXPERIENCES</a>
                            </li>
                            <!--<li role="presentation">
                                <a href="#swapped" aria-controls="swapped" role="tab" data-toggle="tab">SWAPPED</a>
                            </li>-->
                            <li role="presentation">
                                <a href="#reviews" aria-controls="reviews" role="tab" data-toggle="tab">REVIEWS</a>
                            </li>

                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">

                            <div role="tabpanel" class="tab-pane active" id="items">
                                <div class="row masonry-container">

                                    <?php
                                    if (count($items) > 0) {
                                        foreach ($items as $item) {
                                            $_item = Item::__constructWithIdFromDB($item['item_id']);
                                            //display ITEMS
                                            if ($item['category_type_id'] == CAT_TYPE_ITEM) {
                                                $dir = IMAGES_PATH . $item['photos'] . '/';
                                                $images = ImageController::getAllImagesFromDir($dir);
                                                if (count($images) > 0) {
                                                    $image = $images[0];
                                                } else {
                                                    $image = "";
                                                }
                                                echo '<div class="col-lg-3  col-md-4 col-sm-6 col-xs-12  item animation">
										<div class="portfolio-item">
										<div class="portfolio-thumbnail">
											<img class="img-responsive" src="../classes/routers/image_router.php?image=' . urlencode($item['photos'] . $image) . '" alt="...">' .
                                                    '<div class="mask">
												<p>
													<a href="" data-lightbox="template_showcase"> <i class="glyphicon glyphicon-heart"></i>
													</a>
													<a href="item_detail.php?item_id=' . $item['item_id'] .

                                                    '"> <i class="glyphicon glyphicon-link"></i>
													</a>
												</p>
											</div>
										</div>
										<div class="portfolio-description">
											<span class="label label-success" style="filter:alpha(opacity=50);-moz-opacity:0.5;-khtml-opacity: 0.5;opacity: 0.5; ">' .
                                                    $_item->getItemCategoryName($_item->getCategoryTypeId()) . '</span>' .
                                                    '<span class="label label-warning" style="filter:alpha(opacity=50);-moz-opacity:0.5;-khtml-opacity: 0.5;opacity: 0.5; ">' .
                                                    $_item->getItemSubCategoryName($_item->getSubCategoryId()) . '</span>'  .
                                                    '<p>' . $_item->getDescription() . '</p> </div>
											</div></div>';

                                            }
                                        }
                                    }
                                    ?>

                                </div>

                                <!--/.masonry-container  -->
                            </div>
                            <!--/.tab-panel -->

                            <div role="tabpanel" class="tab-pane" id="skills">
                                <div class="row masonry-container">

                                    <?php
                                    if (count($items) > 0) {
                                        foreach ($items as $item) {
                                            $_item = Item::__constructWithIdFromDB($item['item_id']);
                                            //display SKILLS
                                            if ($item['category_type_id'] == CAT_TYPE_SKILL) {
                                                $dir = IMAGES_PATH . $item['photos'] . '/';
                                                $images = ImageController::getAllImagesFromDir($dir);
                                                if (count($images) > 0) {
                                                    $image = $images[0];
                                                } else {
                                                    $image = "";
                                                }
                                                echo '<div class="col-lg-3  col-md-4 col-sm-6 col-xs-12  item animation">
										<div class="portfolio-item">
										<div class="portfolio-thumbnail">
											<img class="img-responsive" src="../classes/routers/image_router.php?image=' . urlencode($item['photos'] . $image) . '" alt="...">' .
                                                    '<div class="mask">
												<p>
													<a href="" data-lightbox="template_showcase"> <i class="glyphicon glyphicon-heart"></i>
													</a>
													<a href="item_detail.php?item_id=' . $item['item_id'] .

                                                    '"> <i class="glyphicon glyphicon-link"></i>
													</a>
												</p>
											</div>
										</div>
										<div class="portfolio-description">
											<span class="label label-success" style="filter:alpha(opacity=50);-moz-opacity:0.5;-khtml-opacity: 0.5;opacity: 0.5; ">' .
                                                    $_item->getItemCategoryName($_item->getCategoryTypeId()) . '</span>' .
                                                    '<span class="label label-warning" style="filter:alpha(opacity=50);-moz-opacity:0.5;-khtml-opacity: 0.5;opacity: 0.5; ">' .
                                                    $_item->getItemSubCategoryName($_item->getSubCategoryId()) . '</span>'  .
                                                    '<p>' . $_item->getDescription() . '</p> </div>
											</div></div>';

                                            }
                                        }
                                    }
                                    ?>

                                </div>

                                <!--/.masonry-container  -->

                            </div>
                            <!--/.tab-panel -->

                            <div role="tabpanel" class="tab-pane" id="experiences">
                                <div class="row masonry-container">

                                    <?php
                                    if (count($items) > 0) {
                                        foreach ($items as $item) {
                                            $_item = Item::__constructWithIdFromDB($item['item_id']);
                                            //display EXPERIENCES
                                            if ($item['category_type_id'] == CAT_TYPE_EXPERIENCE) {
                                                $dir = IMAGES_PATH . $item['photos'] . '/';
                                                $images = ImageController::getAllImagesFromDir($dir);
                                                if (count($images) > 0) {
                                                    $image = $images[0];
                                                } else {
                                                    $image = "";
                                                }
                                                echo '<div class="col-lg-3  col-md-4 col-sm-6 col-xs-12  item animation">
										<div class="portfolio-item">
										<div class="portfolio-thumbnail">
											<img class="img-responsive" src="../classes/routers/image_router.php?image=' . urlencode($item['photos'] . $image) . '" alt="...">' .
                                                    '<div class="mask">
												<p>
													<a href="" data-lightbox="template_showcase"> <i class="glyphicon glyphicon-heart"></i>
													</a>
													<a href="item_detail.php?item_id=' . $item['item_id'] .

                                                    '"> <i class="glyphicon glyphicon-link"></i>
													</a>
												</p>
											</div>
										</div>
										<div class="portfolio-description">
											<span class="label label-success" style="filter:alpha(opacity=50);-moz-opacity:0.5;-khtml-opacity: 0.5;opacity: 0.5; ">' .
                                                    $_item->getItemCategoryName($_item->getCategoryTypeId()) . '</span>' .
                                                    '<span class="label label-warning" style="filter:alpha(opacity=50);-moz-opacity:0.5;-khtml-opacity: 0.5;opacity: 0.5; ">' .
                                                    $_item->getItemSubCategoryName($_item->getSubCategoryId()) . '</span>'  .
                                                    '<p>' . $_item->getDescription() . '</p> </div>
											</div></div>';

                                            }
                                        }
                                    }
                                    ?>

                                </div>
                                <!--/.masonry-container  -->
                            </div>
                            <!--/.tab-panel -->

                            <!--             <div role="tabpanel" class="tab-pane" id="swapped">
                                <?php /*if (count($items) > 0) {
                                    foreach ($items as $item) {
                                        $_item = Item::__constructWithIdFromDB($item['item_id']);
                                        $exchange_by_offeror = ExchangeCollection::getExchangeByItemOfferor($_item->getItemId());
                                        $exchange_by_acceptor = ExchangeCollection::getExchangeByItemAcceptor($_item->getItemId());

                                        if (count($exchange_by_offeror) > 0 && $exchange_by_offeror['status_type_id'] == EXCHANGE_STATUS_COMPLETED) {
                                            $exchange = Exchange::__constructWithIdFromDB($exchange_by_offeror['exchange_id']);
                                            $offeror = User::__constructWithIdFromDB($exchange->getUserIdOfferor());
                                            $acceptor = User::__constructWithIdFromDB($exchange->getUserIdAcceptor());
                                            $offeror_item = Item::__constructWithIdFromDB($exchange->getItemIdOfferor());
                                            $acceptor_item = Item::__constructWithIdFromDB($exchange->getItemIdAcceptor());
                                            include('share_page/swapped_theirprofile.php');

                                        } elseif (count($exchange_by_acceptor) > 0 && $exchange_by_acceptor['status_type_id'] == EXCHANGE_STATUS_COMPLETED) {
                                            $exchange = Exchange::__constructWithIdFromDB($exchange_by_acceptor['exchange_id']);
                                            $offeror = User::__constructWithIdFromDB($exchange->getUserIdOfferor());
                                            $acceptor = User::__constructWithIdFromDB($exchange->getUserIdAcceptor());
                                            $offeror_item = Item::__constructWithIdFromDB($exchange->getItemIdOfferor());
                                            $acceptor_item = Item::__constructWithIdFromDB($exchange->getItemIdAcceptor());
                                            include('share_page/swapped_theirprofile.php');

                                        } else {
                                            $exchange = new Exchange();
                                            $offeror = new User();
                                            $acceptor = new User();
                                            $offeror_item = new Item();
                                            $acceptor_item = new Item();
                                        }

                                    }
                                }
                                */ ?>
                            </div>-->
                            <!--/.tab-panel -->
                            <?php
                            require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/collections/ReviewsCollection.php');
                            require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/models/Review.php');
                            $reviews = ReviewsCollection::getReviewsByUserIdNewestFirst($user->getUserId());
                            ?>
                            <div role="tabpanel" class="tab-pane" id="reviews">
                                <div class="container" style="margin-top: 20px;">
                                    <?php foreach ($reviews as $r) {
                                        $review = Review::__constructWithIdFromDB($r['review_id']);
                                        $reviewer = User::__constructWithIdFromDB($review->getReviewerId());
                                        ?>
                                        <div class="row">
                                            <div class="col-lg-1  col-md-1 col-sm-2  col-xs-4 ">
                                                <a href="theirprofile.php?user_id=<?php echo $review->getReviewerId() ?>">
                                                    <img
                                                        src="../classes/routers/image_router.php?image=<?php echo $reviewer->getProfilePic() ?>"
                                                        class="img-person"></a>
                                                <p><?php echo $reviewer->getName() ?></p>
                                            </div>
                                            <div class="col-lg-1  col-md-2 col-sm-2 col-xs-8  ">
                                                    <?php if ($review->getEvaluation() == THUMBS_DOWN) { ?>
                                                <p style="font-size: 30px;color: #d9534f;">
                                                    <span class="glyphicon glyphicon-thumbs-down"></span>
                                                    </p>
                                                    <?php } else { ?>
                                                <p style="font-size: 30px;color: #5cb85c;">
                                                        <span class="glyphicon glyphicon-thumbs-up"></span>
                                                    </p>
                                                    <?php } ?>
                                            </div>
                                            <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
                                                <?php echo $review->getDescription()?>
                                            </div>
                                        </div>

                                    <?php } ?>
                                </div>
                            </div>


                        </div>
                        <!--/.tab-content -->

                    </div>
                    <!--/.tab-panel  -->

                </div>
                <!-- /.container -->
                <script type="text/javascript">
                    (function ($) {

                        var $container = $('.masonry-container');
                        $container.imagesLoaded(function () {
                            $container.masonry({
                                columnWidth: '.item',
                                itemSelector: '.item'
                            });
                        });
                        //Reinitialize masonry inside each panel after the relative tab link is clicked - 
                        $('a[data-toggle=tab]').each(function () {
                            var $this = $(this);

                            $this.on('click', function () {

                                $container.imagesLoaded(function () {
                                    $container.masonry({
                                        columnWidth: '.item',
                                        itemSelector: '.item'
                                    });
                                });

                            }); //end shown
                        });  //end each

                    })(jQuery);
                </script>
            </div>
        </div>
    </div>
    <!-- footer begin -->
    <footer id="footer" class="footer">
        <?php include("share_page/footer.html"); ?></footer>
</body>
</html>