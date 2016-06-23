<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/helpers/functions.php');
updateSession();

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/constants/Constants.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/models/User.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/models/Item.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/controllers/ImageController.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/controllers/ErrorsController.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/collections/ItemsCollection.php');

if (isset($_SESSION["user_id"])) {
    $_user = User::__constructWithIdFromDB(urlencode($_SESSION["user_id"]));
} else {
    //redirect_to("home.php");
    //in case redirect doesn't work I don't want page to crush by calling methods on null object
    $_user = new User();
}
$items_collection = new ItemsCollection();
$items = $items_collection->getMostRecentItems();
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
    <link rel="stylesheet" type="text/css" href="../css/home_style.css" media="screen">
    <script src="../js/jquery-1.9.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../css/zlight.menu.css" media="screen">
    <script src="../js/jquery.zlight.menu.1.0.min.js"></script>
    <script src="../js/respond.min.js"></script>
    <script type="text/javascript" src="../js/content.js"></script>
    <script src='../js/imagesLoaded.js'></script>
    <script type="text/javascript" src="../js/masonry.pkgd.min.js"></script>
    <link rel="stylesheet" href="../css/like_heart.css" media="screen">
    <script type="text/javascript" src="../js/GoTop.js"></script>
</head>
<body>
<header>
    <?php
    if ((isset($_SESSION["user_id"]) && !empty($_SESSION["user_id"]))) include("share_page/header_logged_new.php");
    else include("share_page/header.php"); ?>

    <div class="container">
        <div class="row">
            <!-- Carousel begin -->
            <div class="col-lg-12 col-xs-12 col-md-12 col-sm-12">
                <div id="myCarousel" class="carousel slide">
                    <ol class="carousel-indicators">
                        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#myCarousel" data-slide-to="1"></li>
                        <li data-target="#myCarousel" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="item active">
                            <img src="../images/carousel1.jpg" class="img-responsive" alt="First slide"></div>
                        <div class="item">
                            <img src="../images/carousel2.jpg" class="img-responsive" alt="Second slide"></div>
                        <div class="item">
                            <img src="../images/carousel3.jpg" class="img-responsive" alt="Third slide"></div>
                    </div>
                    <a class="carousel-control left" href="#myCarousel" role="button"
                       data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control right" href="#myCarousel" role="button"
                       data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="alert alert-danger fade in" style="margin-top: 10px;">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            <div class="row">
                <div class="col-lg-1 col-md-1 col-sm-1"><span
                        style="color: #a94442;font-size: 35px;padding: 20px 0 10px 10px;"
                        class="glyphicon glyphicon-warning-sign "></span></div>
                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12"><h4>DISCLAIMER</h4>
                    <p>This web application is an academic exercise. It is for testing purposes only, not a live
                        product. If you decide to continue and use this service, you can use it at your own risk. The
                        Swope development team will not be hold responsible for any incident, damage or loss
                        incurred.</p>
                    <a href="#" class="close btn btn-danger" data-dismiss="alert" aria-label="close" role="button"
                       style="font-size: 15px;">OK,I got it</a></div>
            </div>
        </div>

        <hr>

        <?php include('share_page/message_box.php') ?>

        <div class="row" align="center">
            <div class="menu">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                    <a href="cate_items.php?category_type_id=<?php echo urlencode(ITEM) ?>">
                        <p style="background:url(../images/menu_items.jpg);">ITEMS</p>
                    </a>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                    <a href="cate_skills.php?category_type_id=<?php echo urlencode(SKILL) ?>">
                        <p style="background:url(../images/menu_skills.jpg);">SKILLS</p>
                    </a>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                    <a href="cate_experiences.php?category_type_id=<?php echo urlencode(EXPERIENCE) ?>">
                        <p style="background:url(../images/menu_exper.jpg);">EXPERIENCES</p>
                    </a>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-lg-2">
                <a href="home.php"
                   style="color: #00AA9E;font-size: 30px;font-weight: normal;line-height: 30px;font-family:Ave Fedan PERSONAL USE ONLY;">Swope</a>
                <span class="glyphicon glyphicon-heart"
                      style="color: #D45D00;font-size: 35px;width: 3%;vertical-align: middle;margin: 0 7px 0 5px;"></span>
            </div>
            <div class="col-lg-10">
                <h3 style="color: #808080;font-weight: 100;font-size: 19px;margin: 0;">Get inspired by Favorites Lists
                    from our home community.</h3>
            </div>
        </div>
        <!-- Exchange items begin -->
        <div class="row" id="isotope-container" style="margin-top: 2%;">

            <?php
            if (count($items) > 0) {
                foreach ($items as $item) {
                    $_item = Item::__constructWithIdFromDB($item['item_id']);
                    $item_owner = User::__constructWithIdFromDB($_item->getUserId());
                    $dir = IMAGES_PATH . $_item->getPhotos() . '/';
                    $images = ImageController::getAllImagesFromDir($dir);
                    if (count($images) > 0) {
                        $image = $images[0];
                    } else {
                        $image = "";
                    }

                    echo '<div class="col-lg-3  col-md-4 col-sm-6 col-xs-12  isotope-item animation">
				<div class="portfolio-item">
					<div class="portfolio-thumbnail">
						<img class="img-responsive" src="../classes/routers/image_router.php?image=' . urlencode($_item->getPhotos() . $image) . '" alt="...">' .
                        '<div class="mask">
							<p>							
								<a id="' . $_item->getItemId() . '" value="' . $_user->getUserId() . '" class="like_heart" data-lightbox="template_showcase"> <i class="glyphicon glyphicon-heart"></i>
								</a>
								<a href="item_detail.php?item_id=' . urlencode($_item->getItemId()) . '"> <i class="glyphicon glyphicon-link"></i>
								</a>
							</p>
						</div>
					</div>
					<div class="portfolio-description">
						<a href="theirprofile.php?user_id=' . urlencode($item_owner->getUserId()) . '">
							<img class="img-person" src="../classes/routers/image_router.php?image=' . $item_owner->getProfilePic() . '" />
						</a>
						<p> <strong style="color: #000;text-align: center;">' . $_item->getName() . '</strong>
						</p>
						<!-- items name -->
						<p>By: ' . $item_owner->getName() . '</p>
					</div>
				</div>
				<!-- / .portfolio-item -->
			</div>';

                }
            }
            ?>


        </div>
        <hr>
        <div class="row">
            <div class="col-lg-4">
                <a href="home.php"
                   style="color: #00AA9E;font-size: 30px;font-weight: normal;line-height: 30px;font-family:Ave Fedan PERSONAL USE ONLY;">Swope</a>
                <span style="color: #808080;font-weight: 100;font-size: 14px;margin: 0;">VIP AREA</span>
            </div>
        </div>
        <div class="content">
            <div class="features-section">
                <div class="features-section-head text-center">
                    <h2 style="color: #6d7b8a;font-weight: 700;">
                        <span style="color: #eb5367;font-weight: 900;">F</span>
                        eatured season
                    </h2>
                    <p style="color: #6d7b8a;font-weight: 600;margin-top: 1%;">“this season featured products”</p>
                </div>
                <div class="features-section-grids"
                     style="background: url('../images/middle-bg.jpg ') no-repeat 0px 0px;background-size: contain;position: relative;margin:6em 0;">
                    <div class="features-section-grid" style="position: absolute;left: 18%;top: -50px;width: 63%;">
                        <img src="../images/girl.png" width="90%" alt=""/>
                        <div class="girl-info" style="position: relative;">
                            <div class="lonovo"
                                 style="background: rgba(55, 62, 72, 0.8);padding: 3%;position: absolute;top: -50px;left:8%;width: 75%;">
                                <div class="dress">
                                    <h4 style="color: #ccd1d9;font-weight: 600;letter-spacing: 1px;">Graduation
                                        Season</h4>
                                    <p style="color: #eee">
                                        Graduates-to-be set up stands to bargain away those belongings which are
                                        difficult to carry back home or to their rented houses.
                                    </p>
                                </div>

                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="../js/add_wish_list.js"></script>

    <!-- banner-bottom -->
    <div class="banner-bottom">
        <div class="text-center">
            <h2 style="color: #6d7b8a;font-weight: 700;">
                <span style="color: #eb5367;font-weight: 900;">W</span>
                elcome to the SWOPE community
            </h2>
            <p style="color: #6d7b8a;font-weight: 600;margin-top: 1%;">“Meet other swopers just like you.”</p>
        </div>
        <div class="banner-bottom-grids">
            <div class="col-md-6 banner-bottom-grid">
                <div class="col-xs-8 banner-bottom-grid-left">
                    <h4>Vincent, Napier university</h4>
                    <ul>
                        <li>
                            20 &nbsp;&nbsp;
                            <span class="glyphicon glyphicon-cloud" aria-hidden="true"></span>
                        </li>
                        <li>
                            Economics &nbsp;&nbsp;
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                        </li>
                        <li>
                            <a href="cate_skills.php">
                                English, French, Computer Science
                                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                            </a>
                        </li>
                    </ul>
                    <p>
                        I want to exchange some books, as well as pens for study. All my items are in good quality, been
                        protected well, nothing to worry about.
                    </p>

                </div>
                <div class="col-xs-4 banner-bottom-grid-right">
                    <img src="../images/vincent1.jpg" alt=" " class="img-responsive"/>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="col-md-6 banner-bottom-grid">
                <div class="col-xs-4 banner-bottom-grid-right">
                    <img src="../images/vincent2.jpg" alt=" " class="img-responsive"/>
                </div>
                <div class="col-xs-8 banner-bottom-grid-left banner-bottom-grid-l">
                    <h4>Bella, ZZULI</h4>
                    <ul>
                        <li>
                            <span class="glyphicon glyphicon-cloud" aria-hidden="true"></span>
                            19
                            <a href="#"></a>
                        </li>
                        <li>
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                            Law
                            <a href="#"></a>
                        </li>
                        <li>
                            <a href="cate_items.php">
                                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                                scarfs, wardrobe, shoes cabinet
                            </a>
                        </li>
                    </ul>
                    <p>
                        I want to use my daily useless stuffs to exchange with someone who could teach me French. I want
                        to use my iPad to exchange an iPhone.
                    </p>

                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="banner-bottom-grids">
            <div class="col-md-6 banner-bottom-grid">
                <div class="col-xs-8 banner-bottom-grid-left">
                    <h4>Rachel, ZZULI</h4>
                    <ul>
                        <li>
                            21 &nbsp;&nbsp;
                            <span class="glyphicon glyphicon-cloud" aria-hidden="true"></span>
                        </li>
                        <li>
                            Economics &nbsp;&nbsp;
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                        </li>
                        <li>
                            <a href="cate_experiences.php">
                                Zhengzhou, China
                                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                            </a>
                        </li>
                    </ul>
                    <p>
                        This summer I want to travel to Edinburgh, I want to find someone to give​ me some advice about
                        the town. ​ I want to go shopping, get some fashionable clothes as well. ​I want to visit some
                        places of interest, history is better. ​
                    </p>

                </div>
                <div class="col-xs-4 banner-bottom-grid-right">
                    <img src="../images/vincent3.jpg" alt=" " class="img-responsive"/>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="col-md-6 banner-bottom-grid">
                <div class="col-xs-4 banner-bottom-grid-right">
                    <img src="../images/vincent4.jpg" alt=" " class="img-responsive"/>
                </div>
                <div class="col-xs-8 banner-bottom-grid-left banner-bottom-grid-l">
                    <h4>Emily, Napier university</h4>
                    <ul>
                        <li>
                            <span class="glyphicon glyphicon-cloud" aria-hidden="true"></span>
                            20
                            <a href="#"></a>
                        </li>
                        <li>
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                            Art & Design
                            <a href="#"></a>
                        </li>
                        <li>
                            <a href="cate_experiences.php">
                                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                                Edinburgh,United Kingdom
                            </a>
                        </li>
                    </ul>
                    <p>
                        I live in Edinburgh, so I can offer some help if someone want to ask advice about traveling.
                        Next week I will travel to Beijing China. I need someone to tell me about the history of
                        Beijing. I need someone to tell me where to find delicious snacks.
                    </p>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <!-- //banner-bottom -->
    <div class="m_side_btns" id="m_side_btns">

        <a class="side_btn helpBtn" href="support.php#user_help">User help</a>

    </div>

    <!-- footer begin -->
    <footer id="footer" class="footer">
        <?php include("share_page/footer.html"); ?></footer>
</body>
</html>