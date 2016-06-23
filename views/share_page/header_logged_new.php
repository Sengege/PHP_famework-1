<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/helpers/functions.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/models/User.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/models/MessageThread.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/models/Message.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/controllers/ImageController.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/collections/MessagesCollection.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/collections/ExchangeCollection.php');


if (isset($_SESSION["user_id"])) {
    $_user = User::__constructWithIdFromDB(urlencode($_SESSION["user_id"]));
} else {
    redirect_to("home.php");
    //in case redirect doesn't work I don't want page to crush by calling methods on null object
    $_user = new User();
}

?>
<?php
include('navigation.php');
?>

<nav class="navbar navbar-default navbar-fixed-top scrolled" role="navigation">
    <div class="container">
        <div class="row">

            <div class="col-lg-2 col-md-2 col-md-offset-1 col-sm-2 col-sm-offset-1 col-xs-2 col-xs-offset-0">
                <div class="navbar-header">
                    <button aria-expanded="true" type="button" class="navbar-toggle" data-toggle="collapse"
                            data-target="#bs-example-navbar-collapse-1">
                        <span class="fa fa-bars fa-lg"></span>
                    </button>
                    <a href="home.php">
                        <img src="../images/Logo_v3-01.png" width="100%"/>
                    </a>
                </div>
            </div>

            <div
                class="col-lg-5 col-lg-offset-0 col-md-5 col-md-offset-0 col-sm-4 col-sm-offset-0 col-xs-8 col-xs-offset-0">
                <div class="input-group"
                     style="margin-top: 3%;filter:alpha(opacity=70);-moz-opacity:0.7;-khtml-opacity: 0.7;opacity: 0.7; ">
                    <input type="text" class="form-control">
				<span class="input-group-btn">
					<button class="btn btn-default" type="button">
						<span class="glyphicon glyphicon-search"></span>
					</button>
				</span>
                </div>
            </div>
            <div class="col-lg-1 col-lg-offset-3 col-md-1 col-md-offset-3 col-sm-1 col-sm-offset-4 col-xs-2">
                <div class="dropdown">
                    <button type="button" class="btn dropdown-toggle" id="dropdownMenu1"
                            data-toggle="dropdown" style="background-color: #fff;margin-top: 5%;">
                        <?php
                        if ($_user->getProfilePic() == null || empty($_user->getProfilePic())) {
                            echo '<img src="../images/person.jpg" alt="userphoto"  style=" -webkit-border-radius:50px;-moz-border-radius:50px;border-radius:50px; height: 40px; width: 40px;text-align: center; margin: 0 10px 0 0;""></a>';
                        } else {
                            echo '<img src="../classes/routers/image_router.php?image=' . urlencode($_user->getProfilePic()) . '" alt="userphoto" style=" -webkit-border-radius:50px;-moz-border-radius:50px;border-radius:50px;height: 40px; width: 40px;text-align: center; margin: 0 10px 0 0;"></a>';
                        }
                        ?>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="dropdownMenu1">

                        <li role="presentation">
                            <a role="menuitem" tabindex="-1"
                               href="myprofile.php?user_id=<?php echo $_user->getUserId() ?>">
                                <span class="glyphicon glyphicon-user"></span>
                                My profile
                            </a>
                        </li>
                        <li role="presentation" class="divider"></li>
                        <li role="presentation">
                            <a data-toggle="modal" data-target="#messagesModal" role="menuitem" tabindex="-1"
                               href="myprofile.php#messages">
                                <span class="glyphicon glyphicon-envelope"></span>
                                My messages
                            </a>
                        </li>
                        <li role="presentation" class="divider"></li>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="edit_profile.php">
                                <span class="glyphicon glyphicon-edit"></span>
                                Edit profile
                            </a>
                        </li>
                        <li role="presentation" class="divider"></li>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="../classes/routers/logout_router.php?logout=true">
                                <span class="glyphicon glyphicon-log-out"></span>
                                Log out
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</nav>


<div class="modal fade" id="messagesModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <!--<script>
        $(".mymessages").click(function () {
            $('.popover-show').popover('hide');
        });
    </script>-->

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Messages</h4>
            </div>
            <div class="modal-body">
                <div class="container">
                    <?php
                    $header_exchange_collection = new ExchangeCollection();
                    $header_exchanges_acceptor = $header_exchange_collection->getExchangesByAcceptor($_user->getUserId());
                    $header_exchanges_offeror = $header_exchange_collection->getExchangesByOfferor($_user->getUserId());

                    $message_threads_as_sender = MessagesCollection::getDirectMessagesThreadsByUserAsSenderOldestFirst($_user->getUserId());
                    $message_threads_as_receiver = MessagesCollection::getDirectMessagesThreadsByUserAsReceiverOldestFirst($_user->getUserId());

                    if (count($header_exchanges_acceptor) > 0) {
                        $header_exchanges_acceptor_with_messages = ExchangeCollection::getExchangesWithMessageThread($header_exchanges_acceptor);
                    } else {
                        $header_exchanges_acceptor_with_messages = array();
                    }

                    if (count($header_exchanges_offeror) > 0) {
                        $header_exchanges_offeror_with_message = ExchangeCollection::getExchangesWithMessageThread($header_exchanges_offeror);
                    } else {
                        $header_exchanges_offeror_with_message = array();
                    }

                    $joint_array = array_merge($header_exchanges_acceptor_with_messages, $header_exchanges_offeror_with_message);
                    foreach ($joint_array as $header_e) {
                        $exchange_type = true;
                        include('header_messages.php');
                    }

                    foreach ($message_threads_as_sender as $message_thread_as_sender) {
                        $message_thread = MessageThread::__constructWithIdFromDB($message_thread_as_sender['message_thread_id']);
                        $messages = MessagesCollection::getMessagesByThreadIdNewestFirst($message_thread_as_sender['message_thread_id']);
                        $exchange_type = false;
                        include('header_messages.php');
                        ?>

                    <?php }
                    ?>

                    <?php foreach ($message_threads_as_receiver as $message_thread_as_receiver) {
                        $message_thread = MessageThread::__constructWithIdFromDB($message_thread_as_receiver['message_thread_id']);
                        $messages = MessagesCollection::getMessagesByThreadIdNewestFirst($message_thread_as_receiver['message_thread_id']);
                        $exchange_type = false;
                        include('header_messages.php');
                        ?>

                        <?php
                    }
                    ?>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal -->
    </div>
</div>