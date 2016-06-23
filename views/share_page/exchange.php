<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
} ?>

<?php if (isset($_SESSION["user_id"])) { ?>

    <?php
    require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/helpers/functions.php');
    require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/models/User.php');
    require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/models/Item.php');
    require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/controllers/ImageController.php');
    require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/controllers/ErrorsController.php');
    require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/controllers/Login.php');
    require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/collections/ItemsCollection.php');
    require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/collections/WishListCollection.php');

    updateSession();

    if (isset($_SESSION["user_id"])) {
        $_user = User::__constructWithIdFromDB(urlencode($_SESSION["user_id"]));
    } else {
        $_user = new User();
    }
    $items_collection = new ItemsCollection();
    $items = $items_collection->getItemsByUserId($_user->getUserId());
    $initial_selected_id = -1;
    ?>

    <div class="modal fade" id="exchangeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="margin-top: 20%;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">CHOOSE</h4>
                </div>
                <div class="modal-body">
                    <div class="myitem_txt">
                        <div class="choose_wrap">
                            <span class=myitem_tt1>My items：</span>
                            <ul class="choose_myitem">
                                <?php
                                if (count($items) > 0) {

                                    $counter = 0;
                                    foreach ($items as $i) {
                                        $item_small = Item::__constructWithIdFromDB($i['item_id']);
                                        if ($counter == 0) {
                                            echo '<li class="cur nav" id="' . $item_small->getItemId() . '">';
                                            $initial_selected_id = $item_small->getItemId();
                                        } else echo '<li id="' . $item_small->getItemId() . '" class="nav">';
                                        echo '<a title="' . $item_small->getName() . '" href="javascript:void(0)">
														<span>' . $item_small->getName() . '</span>
													</a>
												</li>';
                                        $counter++;
                                    }

                                }

                                ?>
                            </ul>
                        </div>
                        <script type=text/javascript>
                            $(".choose_myitem").find("li").click(function () {
                                var num = ($(this).index());
                                $(this).attr("class", "cur");
                                $(this).siblings("li").removeClass("cur");
                                $(".modal-body").find(".myitem_img").eq(num).siblings(".myitem_img").css("display", "none");
                                $(".modal-body").find(".myitem_img").eq(num).css("display", "block");
                            });
                        </script>
                    </div>
                    <div class="myitem_introlf">
                        <?php
                        if (count($items) > 0) {
                            $counter = 0;
                            foreach ($items as $i) {
                                $item_small = Item::__constructWithIdFromDB($i['item_id']);
                                $dir = IMAGES_PATH . $i['photos'] . '/';
                                $images = ImageController::getAllImagesFromDir($dir);
                                if (count($images) > 0) {
                                    $image = $images[0];
                                } else {
                                    $image = "";
                                }
                                if ($counter == 0) echo '<div class="myitem_img">';
                                else echo '<div style="DISPLAY: none" class="myitem_img">';
                                echo '<img alt="' . $item_small->getName() .
                                    '" src="../classes/routers/image_router.php?image=' .
                                    urlencode($item_small->getPhotos() . $image) . '" " ></div>';
                                $counter++;
                            }

                        }


                        ?>
                    </div>

                </div>
                <div class="modal-footer">

                    <form method="post" action="item_sendrequest.php">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <!-- TODO get this primary button as a main button-->
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        <input type="hidden" name="offeror_item_id" id="offeror_item_id"
                               value="<?php echo $initial_selected_id ?>">
                        <input type="hidden" name="acceptor_item_id" id="acceptor_item_id"
                               value="<?php echo $item->getItemId() ?>">

                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php
} else {
    $login = new Login();
    $login->doLogout();
    redirect_to(PATH_TO_VIEWS . 'home.php?error=' . MESSAGE_LOGGED_OUT_INDEX);
} ?>

<script type="text/javascript">
    $('li.nav').click(function (e) {
        e.preventDefault();
        var id = $(this).attr('id');
        var selected_id = document.getElementById('offeror_item_id');
        selected_id.value = id;
    })
</script>

