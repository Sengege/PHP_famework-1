<?php
if ($exchange_type == true) {
    ?>
    <?php
    $header_exchange = Exchange::__constructWithIdFromDB($header_e['exchange_id']);
    $header_messages = MessagesCollection::getMessagesByThreadIdNewestFirst($header_exchange->getMessageThreadId());
    if (count($header_messages) > 0) {
        $header_m = Message::__constructWithIdFromDB($header_messages[0]['message_id']);
        $header_u = User::__constructWithIdFromDB($header_m->getUserId());
    } else {
        $header_m = new Message();
        $header_u = new User();
    }
    ?>
    <!-- Message thread starts here-->
    <a href="myprofile.php?active_tab=mymessages">
        <div class="row">
            <div class="col-lg-1 col-md-1 col-sm-2 col-xs-2">
                <img
                    src="../classes/routers/image_router.php?image=<?php echo $header_u->getProfilePic() ?>"
                    style="height: 50px;width: 50px;border-radius: 50px;text-align: center;"/>
                <p><strong
                        style="color: #000;text-align: center;"><?php echo $header_u->getName() ?></strong>
                </p>
                <p style="color: #BEBEBE;text-align: left;"
                   class="data"><?php echo date('d/m/Y', strtotime($header_m->getDateTime())) ?></p>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-8 col-xs-12">
                <p><?php echo $header_m->getBody() ?></p>
            </div>
            <!-- Message thread ends here-->

        </div>
    </a>

<?php } else {
    if (count($messages) > 0) {
        $header_m = Message::__constructWithIdFromDB($messages[0]['message_id']);
        $header_u = User::__constructWithIdFromDB($header_m->getUserId());
    } else {
        $header_m = new Message();
        $header_u = new User();
    }
    ?>

    <!-- Message thread starts here-->
    <a href="myprofile.php?active_tab=mymessages">
        <div class="row">
            <div class="col-lg-1 col-md-1 col-sm-2 col-xs-2">
                <img
                    src="../classes/routers/image_router.php?image=<?php echo $header_u->getProfilePic() ?>"
                    style="height: 50px;width: 50px;border-radius: 50px;text-align: center;"/>
                <p><strong
                        style="color: #000;text-align: center;"><?php echo $header_u->getName() ?></strong>
                </p>
                <p style="color: #BEBEBE;text-align: left;"
                   class="data"><?php echo date('d/m/Y', strtotime($header_m->getDateTime())) ?></p>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-8 col-xs-12">
                <p><?php echo $header_m->getBody() ?></p>
            </div>
            <!-- Message thread ends here-->

        </div>
    </a>
<?php } ?>
