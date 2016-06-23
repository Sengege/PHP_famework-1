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
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/collections/SkillsCollection.php');

updateSession();

if (isset($_SESSION["user_id"])) {
    $_user = User::__constructWithIdFromDB(urlencode($_SESSION["user_id"]));
} else {
    redirect_to("home.php");
    //in case redirect doesn't work I don't want page to crush by calling methods on null object
    $_user = new User();
}
$items_collection = new ItemsCollection();
$items = $items_collection->getItemsByUserId($_user->getUserId());
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
    <?php include("share_page/header_logged_new.php"); ?></header>
<div class="container">
    <div class="row" style="background-color: #fff;margin-top: 7%;">
        <div id="myprofile" class="col-lg-3 col-lg-offset-0 col-md-3 col-sm-4  col-xs-12">
            <div class="userphoto">
                <a href="edit_profile.php">
                    <?php
                    if ($_user->getProfilePic() == null || empty($_user->getProfilePic())) {
                        echo '<img src="../images/person.jpg" alt="userphoto" width="100%"  style="border:solid #fff 5px;border-radius:10%;-moz-border-radius: 10%;
-webkit-border-radius: 10%;margin-top: -15%;"></a>';
                    } else {
                        echo '<img src="../classes/routers/image_router.php?image=' . $_user->getProfilePic() . '" alt="userphoto" width="100%"  style="border:solid #fff 5px;border-radius:10%;-moz-border-radius: 10%;
-webkit-border-radius: 10%;margin-top: -15%;"></a>';
                    }
                    ?>

            </div>
        </div>
        <div
            class=" col-lg-6 col-lg-offset-0 col-md-6 col-md-offset-0 col-sm-5 col-sm-offset-0 col-xs-12 col-xs-offset-0">
            <div class="username" style="margin-top: 10px;font-style:italic;font-weight:bold;">
                <span><?php echo $_user->getName() ?></span>
                <?php
                $skills = new SkillsCollection();
                $user_skills = $skills->getUserSkills($_user->getUserId());
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
                    <span class='glyphicon glyphicon-thumbs-up'><?php echo htmlentities($_user->getLikes()) ?></span>
                    <span class='glyphicon glyphicon-thumbs-down'><?php echo $_user->getDislikes() ?></span>
                </p>

            </div>
        </div>
        <!--<div id="myprofile"
             class=" col-lg-2 col-lg-offset-0 col-md-2 col-md-offset-0 col-sm-2 col-sm-offset-0 col-xs-2 col-xs-offset-2">
            <div class="username"
                 style="cursor:pointer;margin-top: 30%;font-style:italic;font-weight:bold;color: #337ab7;">

					<span title="<a >
						<span class='glyphicon glyphicon-thumbs-up'></span>
						<?php /*echo htmlentities($_user->getLikes())*/ ?>
					</a>
					<a>
						<span class='glyphicon glyphicon-thumbs-down'></span>
						<?php /*echo $_user->getDislikes()*/ ?>
					</a>
					" class="user_comment" data-html="true" data-container="body" data-toggle="popover"
                          data-placement="right"
                          data-content="<?php
        /*                          $skills = new SkillsCollection();
                                  $user_skills = $skills->getUserSkills($_user->getUserId());
                                  $counter = 1;
                                  foreach ($user_skills as $skill){
                                      $s = $skills->getSkillById($skill['skill_id']);
                                      echo '<span class=\'label'. ' ';
                                      if ($counter%2 == 0)echo 'label-success\'>' . $s['skill_name'] . '</span><br>';
                                      else echo 'label-warning\'>' . $s['skill_name'] . '</span> ';
                                      $counter++;
                                  }
                                  */ ?>
					"> <?php /*echo $_user->getName() */ ?>
				</span>
            </div>
        </div>-->
        <!--<script>$(function () {
                $("[data-toggle='popover']").popover();
            });
        </script>-->
        <div  class="col-lg-offset-1 col-lg-2 col-md-2 col-md-offset-1 col-sm-2 col-sm-offset-1 hidden-xs"  >
            <div class="edit" style="margin-top: 20%;">
                <a href="edit_profile.php?user_id=<?php echo htmlspecialchars($_user->getUserId()) ?>">
                    <span style="font-size: 30px;" class="glyphicon glyphicon-edit"></span>
                </a>
            </div>


        </div>

        <div class="col-lg-12 col-md-12 col-md-offset-0 col-sm-12 col-xs-12">
            <div class="introduce" style="margin-top: 1%; ">
                <p class="introduction" style="border: none; color:#BEBEBE;"><?php echo $_user->getDescription() ?></p>
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
                        <li role="presentation">
                            <a href="#items" aria-controls="items" role="tab" data-toggle="tab">ITEMS</a>
                        </li>
                        <li role="presentation">
                            <a href="#skills" aria-controls="skills" role="tab" data-toggle="tab">SKILLS</a>
                        </li>
                        <li role="presentation">
                            <a href="#experiences" aria-controls="experiences" role="tab"
                               data-toggle="tab">EXPERIENCES</a>
                        </li>
                        <li role="presentation">
                            <a href="#requests" aria-controls="requests" role="tab" data-toggle="tab">REQUESTS</a>
                        </li>
                        <li role="presentation">
                            <a href="#myrequests" aria-controls="myrequests" role="tab" data-toggle="tab">MY
                                REQUESTS</a>
                        </li>
                        <li role="presentation">
                            <a href="#mymessages" aria-controls="mymessages" role="tab" data-toggle="tab">MESSAGES</a>
                        </li>
                        <li role="presentation">
                            <a href="#wishlist" aria-controls="wishlist" role="tab" data-toggle="tab">WISHLIST</a>
                        </li>
                    </ul>

                    <?php if (isset($_GET['active_tab'])) {
                        $active_tab = '#' . $_GET['active_tab'];
                    } else {
                        $active_tab = '#items';
                    } ?>

                    <!-- Tab panes -->
                    <div class="tab-content">

                        <div role="tabpanel" class="tab-pane active" id="items">
                            <div class="row masonry-container">

                                <div class="col-lg-3  col-md-4 col-sm-6 col-xs-12 item animation">
                                    <div class="thumbnail">

                                        <div data-toggle="modal" class="add_items" data-target="#img_itemsupload"
                                             style="margin:10px;height: 326px;border: 2px dashed #dedede;cursor: pointer;">
                                            <i style="display: block;width: 48px;height: 48px;background: url(../images/+.png) 0 0 no-repeat;margin: 128px auto 10px;"></i>
                                            <div class="caption">
                                                <span
                                                    style="display: block;color: #777;text-align: center;">Add item</span>
                                            </div>
                                        </div>
                                        <script>$(".add_items").click(function () {
                                                $('.popover-show').popover('hide');
                                            });</script>

                                        <?php include("share_page/img_itemsupload.html"); ?></div>
                                </div>

                                <!--/.item  -->
                                <?php
                                if (count($items) > 0) {
                                    foreach ($items as $item) {
                                        //display ITEMS
                                        if ($item['category_type_id'] == CAT_TYPE_ITEM) {
                                            $_item = Item::__constructWithIdFromDB($item['item_id']);
                                            $dir = IMAGES_PATH . $item['photos'] . '/';
                                            $images = ImageController::getAllImagesFromDir($dir);
                                            if (count($images) > 0) {
                                                $image = $images[0];
                                            } else {
                                                $image = "";
                                            }
                                            ?>
                                            <div class="col-lg-3  col-md-4 col-sm-6 col-xs-12 item animation">
                                                <div class="portfolio-item">
                                                    <div class="portfolio-thumbnail">
                                                        <img class="img-responsive"
                                                             src="../classes/routers/image_router.php?image=<?php echo urlencode($item['photos'] . $image) ?>"
                                                             alt="...">
                                                        <div class="mask">
                                                            <p>
                                                                <a href="edit_product.php?item_id=<?php echo $item['item_id']?>" data-lightbox="template_showcase" data-toggle="modal">
                                                                    <i class="glyphicon glyphicon-edit"></i>
                                                                </a>
                                                                <a href="item_detail.php?item_id=<?php echo $item['item_id'] ?>">
                                                                    <i class="glyphicon glyphicon-link"></i>
                                                                </a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="portfolio-description">
                                                        <span class="label label-success" style="filter:alpha(opacity=50);-moz-opacity:0.5;-khtml-opacity: 0.5;opacity: 0.5; "><?php echo strtolower($_item->getItemCategoryName($_item->getCategoryTypeId())) ?></span>
                                                        <span class="label label-warning" style="filter:alpha(opacity=50);-moz-opacity:0.5;-khtml-opacity: 0.5;opacity: 0.5; "><?php echo strtolower($_item->getItemSubCategoryName($_item->getSubCategoryId())) ?></span>
                                                        <p><?php echo $item['description'] ?></p>
                                                    </div>
                                                </div>

                                            </div>

                                            <!-- Modal -->
                                            <div id="myModal_<?php echo $item['item_id'] ?>" class="modal fade"
                                                 role="dialog">
                                                <div class="modal-dialog">

                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close"
                                                                    data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">Confirm!</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete it?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">Cancel
                                                            </button>
                                                            <a href="../classes/routers/delete_object_router.php?item_id=<?php echo $item['item_id'] ?>"
                                                               class="btn btn-default">
                                                                Delete
                                                            </a>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <?php
                                        }
                                    }
                                }
                                ?>
                                <!--/.item  -->

                            </div>
                            <!--/.masonry-container  -->
                        </div>
                        <!--/.tab-panel -->

                        <div role="tabpanel" class="tab-pane" id="skills">

                            <div class="row masonry-container">

                                <div class="col-lg-3  col-md-4 col-sm-6 col-xs-12 item">
                                    <div class="thumbnail">

                                        <div data-toggle="modal" class="add_skills" data-target="#img_skillsupload"
                                             style="margin:10px;height: 326px;border: 2px dashed #dedede;cursor: pointer;">
                                            <i style="display: block;width: 48px;height: 48px;background: url(../images/+.png) 0 0 no-repeat;margin: 128px auto 10px;"></i>
                                            <div class="caption">
                                                <span
                                                    style="display: block;color: #777;text-align: center;">Add skills</span>
                                            </div>
                                        </div>
                                        <script>$(".add_skills").click(function () {
                                                $('.popover-show').popover('hide');
                                            });</script>
                                        <?php include("share_page/img_skillsupload.html"); ?>
                                    </div>
                                </div>

                                <!--/.item  -->
                                <?php
                                if (count($items) > 0) {
                                    foreach ($items as $item) {
                                        //display SKILLS
                                        if ($item['category_type_id'] == CAT_TYPE_SKILL) {
                                            $_item = Item::__constructWithIdFromDB($item['item_id']);
                                            $dir = IMAGES_PATH . $item['photos'] . '/';
                                            $images = ImageController::getAllImagesFromDir($dir);
                                            if (count($images) > 0) {
                                                $image = $images[0];
                                            } else {
                                                $image = "";
                                            }
                                            ?>
                                            <div class="col-lg-3  col-md-4 col-sm-6 col-xs-12 item animation">
                                                <div class="portfolio-item">
                                                    <div class="portfolio-thumbnail">
                                                        <img class="img-responsive"
                                                             src="../classes/routers/image_router.php?image=<?php echo urlencode($item['photos'] . $image) ?>"
                                                             alt="...">
                                                        <div class="mask">
                                                            <p>
                                                                <a href="edit_product.php?item_id=<?php echo $item['item_id'] ?>" data-lightbox="template_showcase">
                                                                    <i class="glyphicon glyphicon-edit"></i>
                                                                </a>
                                                                <a href="item_detail.php?item_id=<?php echo $item['item_id'] ?>">
                                                                    <i class="glyphicon glyphicon-link"></i>
                                                                </a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="portfolio-description">
                                                        <span class="label label-success"
                                                              style="filter:alpha(opacity=50);-moz-opacity:0.5;-khtml-opacity: 0.5;opacity: 0.5; "><?php echo strtolower($_item->getItemCategoryName($_item->getCategoryTypeId())) ?></span>
                                                        <span class="label label-warning" style="filter:alpha(opacity=50);-moz-opacity:0.5;-khtml-opacity: 0.5;opacity: 0.5; "><?php echo strtolower($_item->getItemSubCategoryName($_item->getSubCategoryId())) ?></span>

                                                        <p><?php echo $item['description'] ?></p>
                                                    </div>
                                                </div>

                                            </div>

                                            <!-- Modal -->
                                            <div id="myModal_<?php echo $item['item_id'] ?>" class="modal fade"
                                                 role="dialog">
                                                <div class="modal-dialog">

                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close"
                                                                    data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">Confirm!</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete it?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">Cancel
                                                            </button>
                                                            <a href="../classes/routers/delete_object_router.php?item_id=<?php echo $item['item_id'] ?>"
                                                               class="btn btn-default">
                                                                Delete
                                                            </a>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                                <!--/.item  -->

                            </div>
                            <!--/.masonry-container  -->

                        </div>
                        <!--/.tab-panel -->

                        <div role="tabpanel" class="tab-pane" id="experiences">
                            <div class="row masonry-container">

                                <div class="col-lg-3  col-md-4 col-sm-6 col-xs-12 item">
                                    <div class="thumbnail">

                                        <div data-toggle="modal" class="add_exper" data-target="#img_experupload"
                                             style="margin:10px;height: 326px;border: 2px dashed #dedede;cursor: pointer;">
                                            <i style="display: block;width: 48px;height: 48px;background: url(../images/+.png) 0 0 no-repeat;margin: 128px auto 10px;"></i>
                                            <div class="caption">
                                                <span style="display: block;color: #777;text-align: center;">Add experiences</span>
                                            </div>
                                        </div>
                                        <script>$(".add_exper").click(function () {
                                                $('.popover-show').popover('hide');
                                            });</script>
                                        <?php include("share_page/img_experupload.html"); ?>
                                    </div>
                                </div>

                                <!--/.item  -->
                                <?php
                                if (count($items) > 0) {
                                    foreach ($items as $item) {
                                        //display ITEMS
                                        if ($item['category_type_id'] == CAT_TYPE_EXPERIENCE) {
                                            $_item = Item::__constructWithIdFromDB($item['item_id']);
                                            $dir = IMAGES_PATH . $item['photos'] . '/';
                                            $images = ImageController::getAllImagesFromDir($dir);
                                            if (count($images) > 0) {
                                                $image = $images[0];
                                            } else {
                                                $image = "";
                                            }
                                            ?>
                                            <div class="col-lg-3  col-md-4 col-sm-6 col-xs-12 item animation">
                                                <div class="portfolio-item">
                                                    <div class="portfolio-thumbnail">
                                                        <img class="img-responsive"
                                                             src="../classes/routers/image_router.php?image=<?php echo urlencode($item['photos'] . $image) ?>"
                                                             alt="...">
                                                        <div class="mask">
                                                            <p>
                                                                <a href="edit_product.php?item_id=<?php echo $item['item_id'] ?>" data-lightbox="template_showcase">
                                                                    <i class="glyphicon glyphicon-trash"></i>
                                                                </a>
                                                                <a href="item_detail.php?item_id=<?php echo $item['item_id'] ?>">
                                                                    <i class="glyphicon glyphicon-link"></i>
                                                                </a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="portfolio-description">
                                                        <span class="label label-success"
                                                              style="filter:alpha(opacity=50);-moz-opacity:0.5;-khtml-opacity: 0.5;opacity: 0.5; "><?php echo strtolower($_item->getItemCategoryName($_item->getCategoryTypeId())) ?></span>
                                                        <span class="label label-warning" style="filter:alpha(opacity=50);-moz-opacity:0.5;-khtml-opacity: 0.5;opacity: 0.5; "><?php echo strtolower($_item->getItemSubCategoryName($_item->getSubCategoryId())) ?></span>
                                                        <p><?php echo $item['description'] ?></p>
                                                    </div>
                                                </div>

                                            </div>

                                            <!-- Modal -->
                                            <div id="myModal_<?php echo $item['item_id'] ?>" class="modal fade"
                                                 role="dialog">
                                                <div class="modal-dialog">

                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close"
                                                                    data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">Confirm!</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete it?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">Cancel
                                                            </button>
                                                            <a href="../classes/routers/delete_object_router.php?item_id=<?php echo $item['item_id'] ?>"
                                                               class="btn btn-default">
                                                                Delete
                                                            </a>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <?php
                                        }
                                    }
                                }
                                ?>
                                <!--/.item  -->
                            </div>
                            <!--/.masonry-container  -->
                        </div>
                        <!--/.tab-panel -->
                        <div role="tabpanel" class="tab-pane" id="requests">

                            <?php
                            $acceptor_bool = true;
                            include('share_page/request_element.php');
                            ?>

                        </div>

                        <div role="tabpanel" class="tab-pane" id="myrequests">

                            <?php
                            $acceptor_bool = false;
                            include('share_page/request_element.php');
                            ?>

                        </div>

                        <div role="tabpanel" class="tab-pane" id="mymessages">
                            <?php include("share_page/messages.php"); ?></div>
                        <!--/.tab-panel -->
                        <div role="tabpanel" class="tab-pane" id="wishlist">
                            <?php include("share_page/myprofile_wishlist.php"); ?></div>

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
<link href="../css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
<script src="../js/fileinput.js" type="text/javascript"></script>
<script>
    $('.nav a[href=<?php echo $active_tab?>]').tab('show');
</script>
<!-- footer begin -->
<footer id="footer" class="footer">
    <?php include("share_page/footer.html"); ?></footer>

</body>
</html>