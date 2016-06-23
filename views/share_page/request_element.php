<?php
/**
 * Created by PhpStorm.
 * User: adamkisala
 * Date: 08/05/2016
 * Time: 20:33
 */
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/collections/MessagesCollection.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/collections/ExchangeCollection.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/models/Exchange.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/models/Item.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/models/User.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/models/MessageThread.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/constants/Constants.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/collections/ReviewsCollection.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/models/Review.php');

$exchanges_collection = new ExchangeCollection();
if ($acceptor_bool) $exchanges_offered = $exchanges_collection->getExchangesByAcceptor($_user->getUserId());
else $exchanges_offered = $exchanges_collection->getExchangesByOfferor($_user->getUserId());

if (!$exchanges_offered) $exchanges_offered = array();
$counter = 0;
?>
<?php foreach ($exchanges_offered as $o) {
    $offer = Exchange::__constructWithIdFromDB($o['exchange_id']);
    $offeror = User::__constructWithIdFromDB($offer->getUserIdOfferor());
    $acceptor = User::__constructWithIdFromDB($offer->getUserIdAcceptor());
    $offeror_item = Item::__constructWithIdFromDB($offer->getItemIdOfferor());
    $acceptor_item = Item::__constructWithIdFromDB($offer->getItemIdAcceptor());

    $messages = MessagesCollection::getMessagesByThreadIdNewestFirst($offer->getMessageThreadId());

    $message_thread = MessageThread::__constructWithIdFromDB($offer->getMessageThreadId());


    $dir_offeror = IMAGES_PATH . $offeror_item->getPhotos() . '/';
    $dir_acceptor = IMAGES_PATH . $acceptor_item->getPhotos() . '/';

    $offeror_images = ImageController::getAllImagesFromDir($dir_offeror);
    $acceptor_images = ImageController::getAllImagesFromDir($dir_acceptor);

    if (count($offeror_images) > 0) {
        $offeror_image = $offeror_images[0];
    } else {
        $offeror_image = "";
    }
    if (count($acceptor_images) > 0) {
        $acceptor_image = $acceptor_images[0];
    } else {
        $acceptor_image = "";
    }
    ?>

    <br>
    <div class="row">
        <div id="myprofile_request"
             class="col-lg-2 col-lg-offset-0 col-md-2 col-md-offset-0  col-sm-3 col-sm-offset-2 col-xs-4">
            <a href="item_detail.php?item_id=<?php echo $offer->getItemIdOfferor() ?>">
                <img class="img-rounded"
                     src="../classes/routers/image_router.php?image=<?php echo urlencode($offeror_item->getPhotos() . $offeror_image) ?>"
                     style="width:90%"></a>
            <p align="center"><?php echo $offeror_item->getName() ?></p>
        </div>

        <div
            class="col-lg-2 col-lg-offset-0 col-md-2 col-md-offset-0 col-sm-3 col-sm-offset-0 col-xs-4">

            <img src="../images/exch.png" style="width:60%;margin-top: 10%"></div>

        <div id="myprofile_request"
             class="col-lg-2 col-lg-offset-0 col-md-2 col-md-offset-0 col-sm-3 col-sm-offset-0 col-xs-4 col-xs-offset-0">
            <a href="item_detail.php?item_id=<?php echo $offer->getItemIdAcceptor() ?>">
                <img class="img-rounded"
                     src="../classes/routers/image_router.php?image=<?php echo urlencode($acceptor_item->getPhotos() . $acceptor_image) ?>"
                     style="width:90%;"></a>
            <p align="center"><?php echo $acceptor_item->getName() ?></p>
        </div>

        <div
            class="col-lg-3 col-lg-offset-0 col-md-2 col-md-offset-0 col-sm-9 col-sm-offset-2 col-xs-12"
            style="border-right: solid #9F9999 1px;border-left: solid #9F9999 1px;">
            <?php echo $offer->getDescription() ?>
        </div>

        <?php if ($acceptor_bool) {
            $profile_pic = urlencode($offeror->getProfilePic());
            $name = $offeror->getName();
            $id = $offer->getUserIdOfferor();
        } else {
            $profile_pic = urlencode($acceptor->getProfilePic());
            $name = $acceptor->getName();
            $id = $offer->getUserIdAcceptor();
        } ?>

        <div
            class="col-lg-1 col-lg-offset-0 col-md-2 col-md-offset-0 col-sm-2 col-sm-offset-3 col-xs-4">
            <a href="theirprofile.php?user_id=<?php echo $id ?>">
                <img class="img-circle"
                     src="../classes/routers/image_router.php?image=<?php echo $profile_pic ?>"
                     style="width:90%;"></a>
            <p align="center"><?php echo $name ?></p>
        </div>

        <?php
        if ($offer->getStatusTypeId() == EXCHANGE_STATUS_OFFERED && $acceptor_bool) {
            ?>
            <div
                class="col-lg-2 col-lg-offset-0 col-md-2 col-md-offset-0 col-sm-3 col-sm-offset-1 col-xs-6 col-xs-offset-1"
                style="border-left: solid #9F9999 1px;">
                <a href="../classes/routers/exchange_evaluator_router.php?exchange_id=<?php echo $offer->getExchangeId() ?>&cmd=accept"
                >
                    <button type="button" class="btn btn-warning"
                            style="width: 90% ;margin-bottom:10px;margin-top: 10px;">ACCEPT
                    </button>
                </a>
                <br>
                <a class="btn btn-danger" data-toggle="modal" style="width: 90%"
                   data-target="#myModal_exchange_<?php echo $offer->getExchangeId() ?>">DECLINE
                </a>
            </div>
            <!-- Modal -->
            <div id="myModal_exchange_<?php echo $offer->getExchangeId() ?>" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Confirm!</h4>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to decline that offer?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <a href="../classes/routers/exchange_evaluator_router.php?exchange_id=<?php echo $offer->getExchangeId() ?>&cmd=decline"
                               class="btn btn-default">
                                Decline
                            </a>
                        </div>
                    </div>

                </div>
            </div>
            <?php
        } else if ($offer->getStatusTypeId() == EXCHANGE_STATUS_OFFERED && !$acceptor_bool) {
            ?>

            <div
                class="col-lg-2 col-lg-offset-0 col-md-2 col-md-offset-0 col-sm-3 col-sm-offset-1 col-xs-6 col-xs-offset-1"
                style="border-left: solid #9F9999 1px;">
                <!-- if no message thread created yet: create one with pop up message box-->
                <?php if ($offer->getMessageThreadId() == null) { ?>
                    <a data-toggle="modal" data-target="#messagesModal_<?php echo $offer->getExchangeId() ?>"
                       role="menuitem" tabindex="-1"
                       href="myprofile.php#messages_<?php echo $offer->getExchangeId() ?>">
                        <button type="button" class="btn btn-primary" style="width: 90%; margin-top: 10px;">SEND MESSAGE
                        </button>
                    </a>
                    <!-- else re-direct to messages tab -->
                <?php } else { ?>
                    <a role="menuitem" tabindex="-1">
                        <button type="button" id="conversation_<?php echo $offer->getExchangeId() ?>"
                                class="btn btn-primary"
                                style="width: 90%; margin-top: 10px;">CONVERSATION
                        </button>
                    </a>
                    <script>
                        $('#conversation_<?php echo $offer->getExchangeId() ?>').bind('click', function () {
                            $('.nav a[href=#mymessages]').tab('show');
                        });
                    </script>
                <?php } ?>
                <br>
                <a class="btn btn-danger" data-toggle="modal" style="width: 90%; margin-top: 10px;"
                   data-target="#myModal_exchange_<?php echo $offer->getExchangeId() ?>">WITHDRAW
                </a>
            </div>

            <!-- Modal -->
            <div id="myModal_exchange_<?php echo $offer->getExchangeId() ?>" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Confirm!</h4>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to withdraw your offer?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <a href="../classes/routers/exchange_evaluator_router.php?exchange_id=<?php echo $offer->getExchangeId() ?>&cmd=decline"
                               class="btn btn-default">
                                Withdraw
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        <?php } ?>

        <?php if ($offer->getStatusTypeId() == EXCHANGE_STATUS_ACCEPTED) { ?>
            <div
                class="col-lg-2 col-lg-offset-0 col-md-2 col-md-offset-0 col-sm-3 col-sm-offset-1 col-xs-6 col-xs-offset-1"
                style="border-left: solid #9F9999 1px;">
                <a><i class="glyphicon glyphicon-ok" style="color: green;"> ACCEPTED</i>
                </a>
                <br>
                <!-- if no message thread created yet: create one with pop up message box-->
                <?php if ($offer->getMessageThreadId() == null) { ?>
                    <a data-toggle="modal" data-target="#messagesModal_<?php echo $offer->getExchangeId() ?>"
                       role="menuitem" tabindex="-1"
                       href="myprofile.php#messages_<?php echo $offer->getExchangeId() ?>">
                        <button type="button" class="btn btn-primary" style="width: 90%; margin-top: 10px;">SEND MESSAGE
                        </button>
                    </a>
                    <!-- else re-direct to messages tab -->
                <?php } else { ?>
                    <a role="menuitem" tabindex="-1">
                        <button type="button" id="conversation_<?php echo $offer->getExchangeId() ?>"
                                class="btn btn-primary"
                                style="width: 90%; margin-top: 10px;">CONVERSATION
                        </button>
                    </a>
                    <script>
                        $('#conversation_<?php echo $offer->getExchangeId() ?>').bind('click', function () {
                            $('.nav a[href=#mymessages]').tab('show');
                        });
                    </script>
                <?php } ?>
                <a href="../classes/routers/exchange_evaluator_router.php?exchange_id=<?php echo $offer->getExchangeId() ?>&cmd=confirm">
                    <button type="button" class="btn btn-success" style="width: 90%; margin-top: 10px;">CONFIRM</button>
                </a>
            </div>
            <?php
        }
        ?>

        <?php if ($offer->getStatusTypeId() == EXCHANGE_STATUS_DECLINED) { ?>
            <div
                class="col-lg-2 col-lg-offset-0 col-md-2 col-md-offset-0 col-sm-3 col-sm-offset-1 col-xs-6 col-xs-offset-1"
                style="border-left: solid #9F9999 1px;">
                <a><i class="glyphicon glyphicon-remove" style="color: red;"> DECLINED</i>
                </a>
                <br>
                <a href="../classes/routers/exchange_evaluator_router.php?exchange_id=<?php echo $offer->getExchangeId() ?>&cmd=offer">
                    <button type="button" class="btn btn-primary" style="width: 90%; margin-top: 10px;">RESEND OFFER
                    </button>
                </a>
                <br>
                <a class="btn btn-danger" data-toggle="modal" style="width: 90%; margin-top: 10px;"
                   data-target="#myModal_exchange_<?php echo $offer->getExchangeId() ?>">DELETE
                </a>
            </div>

            <!-- Modal -->
            <div id="myModal_exchange_<?php echo $offer->getExchangeId() ?>" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Confirm!</h4>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete that offer?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <a href="../classes/routers/exchange_evaluator_router.php?exchange_id=<?php echo $offer->getExchangeId() ?>&cmd=delete"
                               class="btn btn-default">
                                Delete
                            </a>
                        </div>
                    </div>

                </div>
            </div>
            <?php
        }
        ?>
        <?php

        $reviews_by_exchange = ReviewsCollection::getReviewsByExchangeId($offer->getExchangeId());
        $left_review = false;
        if (count($reviews_by_exchange) > 0){
            foreach ($reviews_by_exchange as $review) {
                if ($review['reviewer_id'] == $_user->getUserId()) $left_review = true;
            }
        }
        ?>
        <?php if (($offer->getStatusTypeId() == EXCHANGE_STATUS_COMPLETED || $offer->getStatusTypeId() == EXCHANGE_STATUS_EVALUATED) && $left_review === false) { ?>
            <div
                class="col-lg-2 col-lg-offset-0 col-md-2 col-md-offset-0 col-sm-3 col-sm-offset-1 col-xs-6 col-xs-offset-1"
                style="border-left: solid #9F9999 1px;">
                <a><i class="glyphicon glyphicon-thumbs-up" style="color: green;"> EXCHANGED</i>
                </a>
                <br>
                <a>
                    <button type="button" class="btn btn-success"
                            id="eval_button_<?php echo $offer->getExchangeId() ?>" data-target="#Evaluation_<?php echo $offer->getExchangeId() ?>"
                            data-toggle="modal" style="width: 90% ;margin-top: 10px;">EVALUATE
                    </button>
                </a>
                <script>$("#eval_button_<?php echo $offer->getExchangeId()?>").click(function () {
                        $('.popover-show').popover('hide');
                    });</script>
                <?php include("share_page/evaluation.php"); ?>
                <br>
                <a class="btn btn-danger" data-toggle="modal" style="width: 90%; margin-top: 10px;"
                   data-target="#myModal_exchange_<?php echo $offer->getExchangeId() ?>">DELETE
                </a>
            </div>

            <!-- Modal -->
            <div id="myModal_exchange_<?php echo $offer->getExchangeId() ?>" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Confirm!</h4>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete that offer?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <a href="../classes/routers/exchange_evaluator_router.php?exchange_id=<?php echo $offer->getExchangeId() ?>&cmd=delete"
                               class="btn btn-default">
                                Delete
                            </a>
                        </div>
                    </div>

                </div>
            </div>
            <?php
        }
        ?>
        <?php if (($offer->getStatusTypeId() == EXCHANGE_STATUS_COMPLETED || $offer->getStatusTypeId() == EXCHANGE_STATUS_EVALUATED) && $left_review === true) { ?>
            <div
                class="col-lg-2 col-lg-offset-0 col-md-2 col-md-offset-0 col-sm-3 col-sm-offset-1 col-xs-6 col-xs-offset-1"
                style="border-left: solid #9F9999 1px;">
                <a><i class="glyphicon glyphicon-thumbs-up" style="color: green;"> EVALUATED</i>
                </a>
                <br>
                <a class="btn btn-danger" data-toggle="modal" style="width: 90%; margin-top: 10px;"
                   data-target="#myModal_exchange_<?php echo $offer->getExchangeId() ?>">DELETE
                </a>
            </div>

            <!-- Modal -->
            <div id="myModal_exchange_<?php echo $offer->getExchangeId() ?>" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Confirm!</h4>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete that offer?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <a href="../classes/routers/exchange_evaluator_router.php?exchange_id=<?php echo $offer->getExchangeId() ?>&cmd=delete"
                               class="btn btn-default">
                                Delete
                            </a>
                        </div>
                    </div>

                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <hr/>

    <!-- INITIAL MESSAGE MODAL -->
    <div class="modal fade" id="messagesModal_<?php echo $offer->getExchangeId() ?>" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel"
         aria-hidden="true">
        <script>
            $(".mymessages_<?php echo $offer->getExchangeId()?>").click(function () {
                $('.popover-show').popover('hide');
            });
        </script>

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" ">Send message</h4>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-1 col-md-1 col-sm-2 col-xs-2">
                                <img src="../classes/routers/image_router.php?image=<?php echo $profile_pic ?>"
                                     style="height: 50px;width: 50px;border-radius: 50px;text-align: center;"/>
                                <p><strong style="color: #000;text-align: center;"><?php echo $name ?></strong>
                                </p>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <!-- Answer-->
                        <div class="col-xs-12">
                            <div id="editor_<?php echo $offer->getExchangeId() ?>">
                                <form role="form" method="post"
                                      action="../classes/routers/exchange_init_message_router.php">
                                    <div class="form-group">
                                        <textarea id="message_<?php echo $offer->getExchangeId() ?>"
                                                  class="form-control"
                                                  name="message"
                                                  rows="1"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                                            <input type="submit" class="form-control btn btn-danger"
                                                   name="submit"
                                                   id="submit_<?php echo $offer->getExchangeId() ?>"
                                                   value="submit"></div>
                                    </div>
                                    <input type="hidden" name="user_id" value="<?php echo $_user->getUserId() ?>">
                                    <input type="hidden" name="exchange_id"
                                           value="<?php echo $offer->getExchangeId() ?>">
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal -->
    <?php

} ?>


