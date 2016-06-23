<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/models/Item.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/collections/WishListCollection.php');

$wish_list = new WishListCollection();
$wish_list_items_ids = $wish_list->getItemsIdsFromWishList($_user->getUserId());
?>
<div class="row masonry-container">

	<?php
	if (count($wish_list_items_ids) > 0) {
		foreach ($wish_list_items_ids as $item) {
			$_item = Item::__constructWithIdFromDB($item['item_id']);
			//display ITEMS

				$dir = IMAGES_PATH . $_item->getPhotos() . '/';
				$images = ImageController::getAllImagesFromDir($dir);
				if (count($images) > 0) {
					$image = $images[0];
				} else {
					$image = "";
				}
				echo '<div class="col-lg-3  col-md-4 col-sm-6 col-xs-12  item animation">
										<div class="portfolio-item">
										<div class="portfolio-thumbnail">
											<img class="img-responsive" src="../classes/routers/image_router.php?image=' . urlencode($_item->getPhotos() . $image) . '" alt="...">' .
					'<div class="mask">
												<p>
													<a href="" id="' . $_item->getItemId() .'" value="' . $_user->getUserId() .'" class="like_heart" data-lightbox="template_showcase"> <i class="glyphicon glyphicon-heart"></i>
								</a>
													<a href="item_detail.php?item_id=' . $_item->getItemId() .

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
	} else {
		echo '<p> </p>';
	}
	?>


</div>

