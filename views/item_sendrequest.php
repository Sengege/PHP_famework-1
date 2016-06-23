<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
} ?>

<?php if (isset($_SESSION["user_id"]) && isset($_POST['submit'])) { ?>

<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/helpers/functions.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/models/User.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/models/Item.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/controllers/ImageController.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/controllers/ErrorsController.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/collections/ItemsCollection.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/collections/WishListCollection.php');

updateSession();


	$acceptor_item = Item::__constructWithIdFromDB($_POST['acceptor_item_id']);
	$offeror_item = Item::__constructWithIdFromDB($_POST['offeror_item_id']);

	$dir = IMAGES_PATH . $acceptor_item->getPhotos() . '/';
	$acceptor_images = ImageController::getAllImagesFromDir($dir);
	if (count($acceptor_images) > 0) {
		$acceptor_image = $acceptor_images[0];
	} else {
		$acceptor_image = "";
	}

	$dir = IMAGES_PATH . $offeror_item->getPhotos() . '/';
	$offeror_images = ImageController::getAllImagesFromDir($dir);
	if(count($offeror_images) > 0){
		$offeror_image = $offeror_images[0];
	} else {
		$offeror_image = "";
	}


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
	<link rel="stylesheet" type="text/css" href="../css/item_detail_style.css" media="screen">
	<link rel="stylesheet" type="text/css" href="../css/jquery.jscrollpane.css" media="all" />
	<link rel="stylesheet" href="../css/zlight.menu.css" media="screen">
	<script src="../js/jquery-1.9.1.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/jquery.zlight.menu.1.0.min.js"></script>
	<script type="text/javascript"  src="../js/content.js"></script>
</head>
<body>
<header>
	<?php
	if((isset($_SESSION["user_id"]) && !empty($_SESSION["user_id"]))) include("share_page/header_logged_new.php");
	else include("share_page/header.php"); ?>
</header>
	<div class="container" style="margin-top:5%;padding:2% 0 2% 0;background-color: #fff;">
		<div class="row">
			<div id="sendrequest" class="col-lg-6 col-lg-offset-4 col-md-6 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-12 col-xs-offset-0">
				<p style="font-family: Ave Fedan PERSONAL USE ONLY;color: #ee8a06;font-size: 36px; ">Send   an   exchange   request</p>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-2 col-lg-offset-3 col-md-2 col-md-offset-2 col-sm-3 col-sm-offset-1 col-xs-4 col-xs-offset-0">
				<img src="../classes/routers/image_router.php?image=<?php echo urlencode($offeror_item->getPhotos() . $offeror_image)?>" width="100%" style="padding:5%;border:2px solid #BEBEBE" />
			</div>
			<div class="col-lg-2 col-md-2 col-md-offset-0 col-sm-3 col-sm-offset-0 col-xs-4 col-xs-offset-0" align="center" style="margin-top: 3%;">
				<img src="../images/exch.png" width="60%"  />
			</div>
			<div class="col-lg-2 col-md-2 col-md-offset-0 col-sm-3 col-sm-offset-0 col-xs-4 col-xs-offset-0">
				<img src="../classes/routers/image_router.php?image=<?php echo urlencode($acceptor_item->getPhotos() . $acceptor_image)?>" width="100%" style="padding:5%;border:2px solid #BEBEBE" />
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-2 col-sm-7 col-sm-offset-2 col-xs-8 col-xs-offset-0">
				<form role="form" method="post" action="../classes/routers/send_exchange_router.php">
					<div class="form-group">
						<div class="col-lg-12 ">
							<label for="name" style="color: #BEBEBE;font-size: 20px; ">Add a message:</label>
							<textarea id="leave_message" name="message" class="form-control" rows="3"></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-2 col-lg-offset-10 col-md-3 col-md-offset-9 col-sm-3 col-sm-offset-9 col-xs-6 col-xs-offset-6" style="margin-top: 2%;">
							<button type="submit" name="submit" class="form-control" id="name" value="submit">Submit</div>
					</div>
					<input type="hidden" name="offeror_item_id" id="offeror_item_id"
						   value="<?php echo $offeror_item->getItemId()?>">
					<input type="hidden" name="acceptor_item_id" id="acceptor_item_id"
						   value="<?php echo $acceptor_item->getItemId() ?>">
				</form>
			</div>
		</div>
	</div>

	<!-- footer begin -->
	<footer id="footer" class="footer" style="margin-top: 10%;">
		<?php include("share_page/footer.html"); ?></footer>
</body>

<?php } else {
	require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/helpers/functions.php');
	redirect_to(PATH_TO_VIEWS . 'home.php');
}?>