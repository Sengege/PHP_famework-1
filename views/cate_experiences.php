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
</head>
<body>
	<header>
		<?php include("share_page/header.php"); ?></header>
	<div class="container" >
		<div class="row" align="center" style="background-image:url( '../images/carousel3.jpg');background-repeat:no-repeat; margin:auto; padding: 10% 0 10% 0;">
			<button type="button" class="btn btn-default btn-lg" style="color: black; opacity:0.7; font-family: Times New Roman; font-size: 35px">
				Experience
				<p>Make life easier</p>
			</button>
		</div>
		<br>
		<div class="row" align="center">
			<div class="menu">
				<div class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
					<a href="cate_exper_cate.php?category_type_id=<?php echo $cat_type?>&sub_category_type_id=<?php echo urlencode(TRAVEL)?>">
						<p style="background:url(../images/menu1.jpg);">TRAVEL</p>
					</a>
				</div>
				<div class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
					<a href="cate_exper_cate.php?category_type_id=<?php echo $cat_type?>&sub_category_type_id=<?php echo urlencode(FOOD)?>">
						<p style="background:url(../images/menu2.jpg);">FOOD</p>
					</a>
				</div>
				<div class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
					<a href="cate_exper_cate.php?category_type_id=<?php echo $cat_type?>&sub_category_type_id=<?php echo urlencode(HISTORY)?>">
						<p style="background:url(../images/menu3.jpg);">HISTORY</p>
					</a>
				</div>
				<div class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
					<a href="cate_exper_cate.php?category_type_id=<?php echo $cat_type?>&sub_category_type_id=<?php echo urlencode(FITNESS)?>">
						<p style="background:url(../images/menu4.jpg);">FITNESS</p>
					</a>
				</div>
				<div class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
					<a href="cate_exper_cate.php?category_type_id=<?php echo $cat_type?>&sub_category_type_id=<?php echo urlencode(CULTURE)?>">
						<p style="background:url(../images/menu5.jpg);">CULTURE</p>
					</a>
				</div>
				<div class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
					<a href="cate_exper_cate.php?category_type_id=<?php echo $cat_type?>&sub_category_type_id=<?php echo urlencode(OTHER)?>">
						<p style="background:url(../images/menu6.jpg);">OTHERS</p>
					</a>
				</div>
			</div>
		</div>

		<!-- Exchange items begin -->
		<div class="row" id="isotope-container">

			<?php
			if (count($items) > 0) {
				foreach ($items as $item) {
					$_item = Item::__constructWithIdFromDB($item['item_id']);
					//display EXPERIENCES
					if ($item['category_type_id'] == 3) {
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
	</div>

<!-- footer begin -->
	<footer id="footer" class="footer" >
		<?php include("share_page/footer.html"); ?></footer>
</body>
</html>