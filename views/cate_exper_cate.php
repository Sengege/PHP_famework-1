<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/helpers/functions.php');
updateSession();

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/models/User.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/models/Item.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/controllers/ImageController.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/controllers/ErrorsController.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/collections/ItemsCollection.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Model.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Database.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/constants/Constants.php');

if (isset($_SESSION["user_id"])) {
	$_user = User::__constructWithIdFromDB(urlencode($_SESSION["user_id"]));
} else {
	//redirect_to("home.php");
	//in case redirect doesn't work I don't want page to crush by calling methods on null object
	//$_user = new User();
}

if(isset($_GET['category_type_id'])){
	$cat_type = urldecode($_GET['category_type_id']);
} else {
	$cat_type = '';
}
if (isset($_GET['sub_category_type_id'])){
	$sub_cat = urldecode($_GET['sub_category_type_id']);
	$sub_cat_id = getIdFromDescription(ITEM_SUB_CATEGORY_TABLE, 'sub_category_name', $sub_cat, 'sub_category_type_id');
} else {
	$sub_cat = '';
	$sub_cat_id = -1;
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
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link rel="stylesheet" type="text/css" href="../css/item_cate_style.css" media="screen">
	<script src="../js/jquery-1.9.1.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../css/zlight.menu.css" media="screen">
	<script src="../js/jquery.zlight.menu.1.0.min.js"></script>
	<script src="../js/respond.min.js"></script>
	<script type="text/javascript"  src="../js/content.js"></script>
	<script src='../js/imagesLoaded.js'></script>
	<script type="text/javascript" src="../js/masonry.pkgd.min.js"></script>
	<link href="../css/font-awesome.min.css" rel="stylesheet"></head>
<body>
<header>
	<?php if((isset($_SESSION["user_id"]) && !empty($_SESSION["user_id"]))) include("share_page/header_logged_new.php");
	else include("share_page/header.php"); ?> </header>
	<div class="wrapper" style="margin-top: 5%;">

		<!-- Topic Header -->
		<div class="topic">
			<div class="container">
				<div class="row">
					<ol class="breadcrumb hidden-xs">
						<li>
							<a href="home.php?category_type_id= <?php echo urlencode(EXPERIENCE)?>">Home</a>
						</li>
						<li>
							<a href="cate_experiences.php">Experiences</a>
						</li>
						<li class="active"><?php echo ucfirst(strtolower($sub_cat))?></li>
					</ol>
				</div>
				<!-- / .row -->
			</div>
			<!-- / .container -->
		</div>
		<!-- / .Topic Header -->

		<div class="container">
			<div class="row" id="isotope-container">

				<?php
				if (count($items) > 0) {
					foreach ($items as $item) {
						$_item = Item::__constructWithIdFromDB($item['item_id']);
						//display EXPERIENCE
						if ($_item->getCategoryTypeId() == CAT_TYPE_EXPERIENCE && $_item->getSubCategoryId() == $sub_cat_id) {
							$dir = IMAGES_PATH . $item['photos'] . '/';
							$images = ImageController::getAllImagesFromDir($dir);
							if (count($images) > 0) {
								$image = $images[0];
							} else {
								$image = "";
							}
							echo '<div class="col-lg-3  col-md-4 col-sm-6 col-xs-12  isotope-item animation">
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
								'<p>' .  $_item->getDescription() . '</p> </div>
											</div></div>';

						}
					}
				}
				?>

				<div class="col-lg-3  col-md-4 col-sm-6 col-xs-12 isotope-item animation">
					<div class="portfolio-thumbnail" >
						<a href="">
							<h3 style="color: #ee8a06;"  align="center">Loading more</h3>
						</a>
					</div>
				</div>
				<script type="text/javascript">
		(function( $ ) {
    var $container = $('#isotope-container');
    $container.imagesLoaded( function () {
        $container.masonry({
            columnWidth: '.isotope-item',
            itemSelector: '.isotope-item'
        });
    });   
    //Reinitialize masonry inside each panel after the relative tab link is clicked - 
    $('a[data-toggle=tab]').each(function () {
        var $this = $(this);

        $this.on('click', function () {
        
            $container.imagesLoaded( function () {
                $container.masonry({
                    columnWidth: '.isotope-item',
                    itemSelector: '.isotope-item'
                });
            });

        }); //end shown
    });  //end each   
})(jQuery);
	</script>
			</div>
			<!-- / .row -->
		</div>
		<!-- / .container -->
	</div>
	<!-- footer begin -->
	<footer id="footer" class="footer" >
		<?php include("share_page/footer.html"); ?></footer>
</body>
</html>