<?php if ($exchange_bool == true) { ?>
    <div class="row">
        <br>
        <div
            class="col-lg-1 col-lg-offset-0 col-md-2 col-md-offset-0 col-sm-2 col-sm-offset-3 col-xs-4">
            <a href="theirprofile.php?user_id=<?php echo $exchange->getUserIdOfferor() ?>">
                <img class="img-circle"
                     src="../classes/routers/image_router.php?image=<?php echo $u->getProfilePic() ?>"
                     style=" -webkit-border-radius:50px;-moz-border-radius:50px;border-radius:50px;height: 40px; width: 40px;text-align: center; margin: 0 10px 0 0;"></a>
            <p align="center"><?php echo $u->getName() ?></p>
        </div>

        <div
            class="col-lg-7 col-lg-offset-0 col-md-2 col-md-offset-0 col-sm-9 col-sm-offset-2 col-xs-12"
            style="border-right: solid #9F9999 1px;border-left: solid #9F9999 1px;">
            <?php echo $exchange->getDescription() ?>
        </div>
        <div
            class="col-lg-2 col-lg-offset-0 col-md-2 col-md-offset-0 col-sm-3 col-sm-offset-0 col-xs-4">

            <img src="../images/exch.png" style="width:30%;">
        </div>
        <div
            class="col-lg-2 col-lg-offset-0 col-md-2 col-md-offset-0 col-sm-3 col-sm-offset-1 col-xs-6 col-xs-offset-1"
            style="border-left: solid #9F9999 1px;">
            <a role="menuitem" tabindex="-1">
                <button type="button" id="message_expand_btn_<?php echo $exchange->getMessageThreadId() ?>"
                        class="btn btn-primary"
                        style="width: 90%; margin-top: 10px;">EXPAND
                </button>
            </a>
        </div>
    </div>

    <div id="inner_messages_<?php echo $exchange->getMessageThreadId() ?>" style="display: none">

        <?php foreach ($messages as $m) {
            $message = Message::__constructWithIdFromDB($m['message_id']);
            $sender = User::__constructWithIdFromDB($message->getUserId());
            ?>
            <br>
            <div class="row">
                <div
                    class="col-lg-1 col-lg-offset-1 col-md-2 col-md-offset-1 col-sm-2 col-sm-offset-3 col-xs-4">
                    <a href="theirprofile.php?user_id=<?php echo $message->getUserId() ?>">
                        <img class="img-circle"
                             src="../classes/routers/image_router.php?image=<?php echo $sender->getProfilePic() ?>"
                             style=" -webkit-border-radius:50px;-moz-border-radius:50px;border-radius:50px;height: 40px; width: 40px;text-align: center; margin: 0 10px 0 0;"></a>
                    <p align="center"><?php echo $sender->getName() ?></p>
                </div>
                <div
                    class="col-lg-7 col-lg-offset-1 col-md-2 col-md-offset-1 col-sm-9 col-sm-offset-2 col-xs-12"
                    style="border-right: solid #9F9999 1px;border-left: solid #9F9999 1px;">
                    <?php echo $message->getBody() ?>
                </div>
            </div>
        <?php } ?>

        <div class="row">
            <div id="editor_<?php echo $exchange->getMessageThreadId() ?>">
                <form role="form" method="post" action="../classes/routers/profile_message_router.php">
                    <div class="form-group">
                        <textarea name="message" class="form-control col-lg-offset-1 col-md-offset-1 col-sm-offset-3"
                                  style="width: 80%;" rows="2"></textarea>
                    </div>
                    <div class="form-group">
                        <div
                            class="col-lg-4 col-lg-offset-1 col-md-4 col-md-offset-1 col-sm-4 col-sm-offset-3 col-xs-6">
                            <input type="submit" class="form-control btn btn-danger" name="submit" value="submit"></div>
                    </div>
                    <input type="hidden" name="user_id" value="<?php echo $_user->getUserId() ?>">
                    <input type="hidden" name="message_thread_id" value="<?php echo $exchange->getMessageThreadId() ?>">
                </form>
            </div>
        </div>
    </div>
    <script>
        $("#message_expand_btn_<?php echo $exchange->getMessageThreadId() ?>").bind('click', function () {
            var btn = document.getElementById("message_expand_btn_<?php echo $exchange->getMessageThreadId() ?>");
            if (btn.innerHTML == "COLLAPSE") btn.innerHTML = "EXPAND";
            else btn.innerHTML = "COLLAPSE";
            $("#inner_messages_<?php echo $exchange->getMessageThreadId()?>").toggle();
        });
    </script>
    <hr>
    <!-- DIRECT MESSAGES-->
<?php } else { ?>
    <div class="row">
        <br>
        <div
            class="col-lg-1 col-lg-offset-0 col-md-2 col-md-offset-0 col-sm-2 col-sm-offset-3 col-xs-4">
            <a href="theirprofile.php?user_id=<?php echo $s->getUserId() ?>">
                <img class="img-circle"
                     src="../classes/routers/image_router.php?image=<?php echo $s->getProfilePic() ?>"
                     style=" -webkit-border-radius:50px;-moz-border-radius:50px;border-radius:50px;height: 40px; width: 40px;text-align: center; margin: 0 10px 0 0;"></a>
            <p align="center"><?php echo $s->getName() ?></p>
        </div>

        <div
            class="col-lg-7 col-lg-offset-0 col-md-2 col-md-offset-0 col-sm-9 col-sm-offset-2 col-xs-12"
            style="border-right: solid #9F9999 1px;border-left: solid #9F9999 1px;">
            <?php echo $messages[0]['message_body'] ?>
        </div>
        <div
            class="col-lg-2 col-lg-offset-0 col-md-2 col-md-offset-0 col-sm-3 col-sm-offset-0 col-xs-4">

            <a href="theirprofile.php?user_id=<?php echo $receiver->getUserId() ?>">
                <img class="img-circle"
                     src="../classes/routers/image_router.php?image=<?php echo $receiver->getProfilePic() ?>"
                     style=" -webkit-border-radius:50px;-moz-border-radius:50px;border-radius:50px;height: 40px; width: 40px;text-align: center; margin: 0 10px 0 0;"></a>
            <p align="center"><?php echo $receiver->getName() ?></p>
        </div>
        <div
            class="col-lg-2 col-lg-offset-0 col-md-2 col-md-offset-0 col-sm-3 col-sm-offset-1 col-xs-6 col-xs-offset-1"
            style="border-left: solid #9F9999 1px;">
            <a role="menuitem" tabindex="-1">
                <button type="button" id="message_expand_btn_<?php echo $message_thread->getMessageThreadId() ?>"
                        class="btn btn-primary"
                        style="width: 90%; margin-top: 10px;">EXPAND
                </button>
            </a>
        </div>
    </div>

    <div id="inner_messages_<?php echo $message_thread->getMessageThreadId() ?>" style="display: none">

        <?php
        $count = 0;
        foreach ($messages as $m) {
            if ($count != 0) {
                $message = Message::__constructWithIdFromDB($m['message_id']);
                $sender = User::__constructWithIdFromDB($message->getUserId());
                ?>
                <br>
                <div class="row">
                    <div
                        class="col-lg-1 col-lg-offset-1 col-md-2 col-md-offset-1 col-sm-2 col-sm-offset-3 col-xs-4">
                        <a href="theirprofile.php?user_id=<?php echo $message->getUserId() ?>">
                            <img class="img-circle"
                                 src="../classes/routers/image_router.php?image=<?php echo $sender->getProfilePic() ?>"
                                 style=" -webkit-border-radius:50px;-moz-border-radius:50px;border-radius:50px;height: 40px; width: 40px;text-align: center; margin: 0 10px 0 0;"></a>
                        <p align="center"><?php echo $sender->getName() ?></p>
                    </div>
                    <div
                        class="col-lg-7 col-lg-offset-1 col-md-2 col-md-offset-1 col-sm-9 col-sm-offset-2 col-xs-12"
                        style="border-right: solid #9F9999 1px;border-left: solid #9F9999 1px;">
                        <?php echo $message->getBody() ?>
                    </div>
                </div>
                <?php
            }
            $count++;
        } ?>

        <div class="row">
            <div id="editor_<?php echo $message_thread->getMessageThreadId() ?>">
                <form role="form" method="post" action="../classes/routers/profile_message_router.php">
                    <div class="form-group">
                        <textarea name="message" class="form-control col-lg-offset-1 col-md-offset-1 col-sm-offset-3"
                                  style="width: 80%;" rows="2"></textarea>
                    </div>
                    <div class="form-group">
                        <div
                            class="col-lg-4 col-lg-offset-1 col-md-4 col-md-offset-1 col-sm-4 col-sm-offset-3 col-xs-6">
                            <input type="submit" class="form-control btn btn-danger" name="submit" value="submit"></div>
                    </div>
                    <input type="hidden" name="user_id" value="<?php echo $_user->getUserId() ?>">
                    <input type="hidden" name="message_thread_id"
                           value="<?php echo $message_thread->getMessageThreadId() ?>">
                </form>
            </div>
        </div>
    </div>
    <script>
        $("#message_expand_btn_<?php echo $message_thread->getMessageThreadId() ?>").bind('click', function () {
            var btn = document.getElementById("message_expand_btn_<?php echo $message_thread->getMessageThreadId() ?>");
            if (btn.innerHTML == "COLLAPSE") btn.innerHTML = "EXPAND";
            else btn.innerHTML = "COLLAPSE";
            $("#inner_messages_<?php echo $message_thread->getMessageThreadId()?>").toggle();
        });
    </script>
    <hr>

<?php } ?>
