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
if (isset($_GET['item_id'])) {
    $item_edit = Item::__constructWithIdFromDB($_GET['item_id']);
    $photos = $item_edit->getPictures();
} else {
    $item_edit = new Item();
    $photos = array();
}

?>

<!DOCTYPE html>
<html>
<head>
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
    <link href="../css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
    <script src="../js/fileinput.js" type="text/javascript"></script>
</head>
<style type="text/css">label {
        color: #8c7e7e;
    }</style>
<body style="background-color: #F2F2EE;">
<header>
    <?php include("share_page/header_logged_new.php"); ?></header>
<div class="topic" style="margin-top: 50px;">
    <div class="container">
        <div class="row">
            <ol class="breadcrumb hidden-xs">
                <li>
                    <a href="myprofile.php">My Profile</a>
                </li>
                <li class="active">Edit</li>
            </ol>
        </div>
        <!-- / .row -->
    </div>
    <!-- / .container -->
</div>
<div class="container">
    <?php include ('share_page/message_box.php');?>
    <div class="row">
        <form role="form" method="post" action="../classes/routers/edit_item_router.php" enctype="multipart/form-data">
            <div class="form-group">
                <input id="test-upload" class="file-loading" name="images[]"  accept="image/jpeg, image/png, image/jpg" type="file"
                       multiple ></div>

        <script>
            $(document).on('ready',function () {
                $("#test-upload").fileinput({
                    'showPreview': true,
                    'allowedFileExtensions': ['jpg', 'png', 'gif', 'jpeg'],
                    'elErrorContainer': '#errorBlock',
                    initialPreview : [ <?php foreach ($photos as $photo) { ?>'<img class=\'file-preview-image\' src="../classes/routers/image_router.php?image=<?php echo urlencode($item_edit->getPhotos() . $photo)?>"/>',<?php }?>],
                    showUpload : false

                });
            });
        </script>

        <div class="form-horizontal">
            <div class="form-group">
                <label class="col-lg-2  col-md-2 col-sm-3  col-xs-12 control-label">Title</label>
                <div class="col-lg-8  col-sm-8 col-xs-10">
                    <input type="text" class="form-control" id="email_address" name="title"
                           placeholder="<?php echo (empty($item_edit->getName())) ? "Title" : $item_edit->getName() ?>"></div>
            </div>

            <div class="form-group">
                <label class="col-lg-2  col-md-2 col-sm-3  col-xs-12 control-label">Description</label>
                <div class="col-lg-8  col-sm-8 col-xs-10">
						<textarea type="text" class="form-control" id="txt_content" name="description"
                                  placeholder="Please add description"><?php echo $item_edit->getDescription() ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2  col-md-2 col-sm-3  col-xs-12 control-label">I Want</label>
                <div class="col-lg-8  col-sm-8 col-xs-10">
                    <input type="text" class="form-control" id="txt_content" name="wanted"
                           placeholder="<?php echo (empty($item_edit->getWanted())) ? "Tell other swopers what you would like in exchange" : $item_edit->getWanted()?>"></div>
            </div>
            <fieldset disabled>
                <div class="form-group">
                    <label class="col-lg-2  col-md-2 col-sm-3  col-xs-12 control-label">Category</label>
                    <div class="col-lg-8  col-sm-8 col-xs-10">
                        <select class="form-control" id="disabledSelect" name="category">
                            <option><?php echo $item_edit->getItemCategoryName($item_edit->getCategoryTypeId()) ?></option>
                        </select>
                    </div>
                </div>
            </fieldset>
            <?php $sub_category = $item_edit->getItemSubCategoryName($item_edit->getSubCategoryId()); ?>
            <div class="form-group">
                <label class="col-lg-2  col-md-2 col-sm-3  col-xs-12 control-label">Subcategory</label>
                <div class="col-lg-8  col-sm-8 col-xs-10">
                    <select class="form-control" id="subcategory_items" name="subcategory">
                        <?php $sub_cats = $item_edit->getSubcategories();
                        foreach ($sub_cats as $sub_cat) { ?>
                            <option <?php echo $s = ($sub_category == $sub_cat['sub_category_name']) ? ' selected="selected"' : ' ' ?>><?php echo $sub_cat['sub_category_name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group" id="items_new_category" style="display:none">
                <label class="col-lg-2  col-md-2 col-sm-3  col-xs-12 control-label">My Category</label>
                <div class="col-lg-8  col-sm-8 col-xs-10">
                    <input type="text" class="form-control" id="own_category" name="my_category"
                           placeholder="<?php echo (empty($item_edit->getMyCategory())) ? "Enter your own category" : $item_edit->getMyCategory()?>"></div>
            </div>
            <script>
                $("#items_other").click(function () {
                    $("#items_new_category").css("display", "block");
                });
                $("#subcategory_items option:eq(0),#subcategory_items option:eq(1),#subcategory_items option:eq(2),#subcategory_items option:eq(3),#subcategory_items option:eq(4)").click(function () {
                    $("#items_new_category").css("display", "none");
                });
            </script>
            <div class="form-group">
                <label class="col-lg-2  col-md-2 col-sm-3  col-xs-12 control-label">Value Category</label>
                <div class="col-lg-8  col-sm-8 col-xs-10">
                    <input type="text" class="form-control" id="value_category" name="value"
                           placeholder="Value category"></div>
            </div>
            <div class="form-group">
                <div class="col-lg-2 col-lg-offset-2 col-md-offset-2 col-sm-offset-3 col-xs-offset-0">
                    <button type="submit" name="submit" class="btn btn-warning">Save changes</button>
                </div>
            </div>
            <input type="hidden" value="<?php echo $item_edit->getItemId()?>" name="item_id">
        </div>
        <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-3 col-xs-offset-0">

            <button class="btn btn-danger" data-toggle="modal" data-target="#myModal">DELETE IT</button>
        </div>
    </div>
</div>

<!-- 模态框（Modal） -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">×
                </button>
                <h4 class="modal-title" id="myModalLabel">Warning</h4>
            </div>
            <div class="modal-body">
                <span style="color: rgb(255, 140, 60);" class="glyphicon glyphicon-exclamation-sign"></span>
					<span style="font-size: 17px;color: #8c7e7e">
						Are you sure you want to delete this product? After deleting this product information will be deleted.
					</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal">CANCEL
                </button>
                <a href="../classes/routers/delete_object_router.php?item_id=<?php echo $item_edit->getItemId(); ?>"
                   class="btn btn-default">
                    DELETE
                </a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

</body>
</html>