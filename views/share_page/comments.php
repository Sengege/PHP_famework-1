<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/collections/MessagesCollection.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/models/MessageThread.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/models/Message.php');

$message_thread = MessageThread::getMessageThreadByItemId($item->getItemId());
$comments = MessagesCollection::getMessagesByThreadIdNewestFirst($message_thread->getMessageThreadId());
?>

<div class="comments">

    <?php if ($is_logged_in && ($_user->getUserId() != $item_owner->getUserId())) { ?>
        <!-- New comment form -->
        <div class="row">
            <div class="cmt col-lg-8 col-lg-offset-2">
                <a href="myprofile.php">
                    <img src="../classes/routers/image_router.php?image=<?php echo $_user->getProfilePic() ?>"
                         alt="..."></a>
                <div class="cmt-block"><strong><?php echo $_user->getName() ?></strong>
                    <form role="form" class="cmt-body" id="comment_form" method="post"
                          action="../classes/routers/comment_router.php">
                        <div class="form-group">
                            <div class="col-lg-12 ">
                                <textarea id="leave_comment" name="comment" required class="form-control" rows="3"
                                          placeholder="Write comment"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div
                                class="col-lg-2 col-lg-offset-10 col-md-3 col-md-offset-9 col-sm-3 col-sm-offset-9 col-xs-6 col-xs-offset-6"
                                style="margin-top: 2%;">
                                <button type="submit" class="form-control"
                                        name="submit" id="name" value="submit">Submit
                                </button>
                            </div>
                        </div>
                        <input type="hidden" name="commentator_id" value="<?php echo $_user->getUserId() ?>">
                        <input type="hidden" name="item_id" value="<?php echo $item->getItemId() ?>">
                    </form>
                </div>
            </div>
        </div>
    <?php }
    ?>

    <?php
    $comments_count = count($comments);
    if ($comments_count > 0) {
        //array to check if submessages are not repeating
        $sub_comments_checked_array = array();

        ?>

        <!-- List of comments -->
        <h4 class="text-right"><?php echo $comments_count ?> comments</h4>
        <hr size="30" style="border-top: 1px solid #fff;">

        <?php foreach ($comments as $c) {
            $comment = Message::__constructWithIdFromDB($c['message_id']);
            $commentator = User::__constructWithIdFromDB($comment->getUserId());
            $sub_messages_thread_id = $comment->getMessageSubThreadId();
            if ($sub_messages_thread_id != null && !empty($sub_messages_thread_id)) {
                $sub_messages = MessagesCollection::getSubMessagesByThreadIdOldestFirst($sub_messages_thread_id);
            } else {
                $sub_messages = array();
            }

            ?>
            <!-- Check for sub messages-->
            <?php if (count($sub_messages) <= 0) { ?>
                <div class="cmt col-lg-8 col-lg-offset-2">
                    <a href="theirprofile.php?user_id=<?php echo $commentator->getUserId() ?>">
                        <img src="../classes/routers/image_router.php?image=<?php echo $commentator->getProfilePic() ?>"
                             alt="..."></a>
                    <div class="cmt-block">
                        <a href="theirprofile.php?user_id=<?php echo $commentator->getUserId() ?>"
                           class="profile-link"><?php echo $commentator->getName() ?></a>
                        <span
                            class="text-muted time"><?php echo date('d/m/Y', strtotime($comment->getDateTime())) ?></span>
                        <p class="cmt-body"><?php echo $comment->getBody() ?>
                        </p>
                        <?php if ($item->getUserId() == $_user->getUserId() && $comment->getUserId() != $_user->getUserId()) {
                            ?>
                            <ul class="list-inline">
                                <li>
                                    <?php include('share_page/message_box.php') ?>
                                    <div id="editor_answer_<?php echo $comment->getMessageId(); ?>">Answer</div>
                                    <div id="editor_<?php echo $comment->getMessageId(); ?>" style="display:none">
                                        <form role="form" method="post" action="../classes/routers/comment_router.php">
                                            <div class="form-group">
                                                <div class="col-lg-12">
                                                    <textarea name="comment"
                                                              id="leave_message_<?php echo $comment->getMessageId(); ?>"
                                                              class="form-control" rows="2"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div
                                                    class="col-lg-2 col-lg-offset-10 col-md-3 col-md-offset-9 col-sm-3 col-sm-offset-9 col-xs-6 col-xs-offset-6"
                                                    style="margin-top: 2%;">
                                                    <button type="submit" class="form-control btn btn-danger"
                                                            id="button_<?php echo $comment->getMessageId() ?>"
                                                            name="submit_answer">Submit
                                                </div>
                                            </div>
                                            <input type="hidden" name="commentator_id"
                                                   value="<?php echo $_user->getUserId() ?>">
                                            <input type="hidden" name="item_id"
                                                   value="<?php echo $item->getItemId() ?>">
                                            <input type="hidden" name="first_message"
                                                   value="<?php echo $comment->getMessageId(); ?>">
                                        </form>
                                    </div>
                                    <script>
                                        $("#editor_answer_<?php echo $comment->getMessageId();?>").click(function () {
                                            $("#editor_<?php echo $comment->getMessageId();?>").toggle();
                                        });
                                    </script>
                                </li>
                            </ul>

                            <?php
                        }
                        ?>
                    </div>
                </div>
            <?php } elseif (!in_array($comment->getMessageSubThreadId(), $sub_comments_checked_array, true)) {
                //go through all sub-messages displaying first one first
                $counter = 0;
                $last_index = count($sub_messages) - 1;
                foreach ($sub_messages as $sub_message) {
                    $comment = Message::__constructWithIdFromDB($sub_message['message_id']);
                    $commentator = User::__constructWithIdFromDB($comment->getUserId());
                    if ($counter == 0) {
                        $first_message = $comment->getMessageId();
                        ?>
                        <div class="cmt col-lg-8 col-lg-offset-2">
                            <a href="theirprofile.php?user_id=<?php echo $commentator->getUserId() ?>">
                                <img
                                    src="../classes/routers/image_router.php?image=<?php echo $commentator->getProfilePic() ?>"
                                    alt="..."></a>
                            <div class="cmt-block">
                                <a href="theirprofile.php?user_id=<?php echo $commentator->getUserId() ?>"
                                   class="profile-link"><?php echo $commentator->getName() ?></a>
                        <span
                            class="text-muted time"><?php echo date('d/m/Y', strtotime($comment->getDateTime())) ?></span>
                                <p class="cmt-body"><?php echo $comment->getBody() ?>
                                </p>

                            </div>
                        </div>

                        <?php
                    } else { ?>
                        <div class="cmt col-lg-8 col-lg-offset-3">
                            <a href="theirprofile.php?user_id=<?php echo $commentator->getUserId() ?>">
                                <img
                                    src="../classes/routers/image_router.php?image=<?php echo $commentator->getProfilePic() ?>"
                                    alt="..."></a>
                            <div class="cmt-block">
                                <a href="theirprofile.php?user_id=<?php echo $commentator->getUserId() ?>"
                                   class="profile-link"><?php echo $commentator->getName() ?></a>
                        <span
                            class="text-muted time"><?php echo date('d/m/Y', strtotime($comment->getDateTime())) ?></span>
                                <p class="cmt-body"><?php echo $comment->getBody() ?>
                                </p>
                                <?php if ($comment->getUserId() != $_user->getUserId() && $counter == $last_index) {
                                    ?>
                                    <ul class="list-inline">
                                        <li>
                                            <div id="editor_answer_<?php echo $comment->getMessageId(); ?>">Answer</div>
                                            <div id="editor_<?php echo $comment->getMessageId(); ?>"
                                                 style="display:none">
                                                <form role="form" method="post"
                                                      action="../classes/routers/comment_router.php">
                                                    <div class="form-group">
                                                        <div class="col-lg-12">
                                                    <textarea name="comment"
                                                              id="leave_message_<?php echo $comment->getMessageId(); ?>"
                                                              class="form-control" rows="2"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div
                                                            class="col-lg-2 col-lg-offset-10 col-md-3 col-md-offset-9 col-sm-3 col-sm-offset-9 col-xs-6 col-xs-offset-6"
                                                            style="margin-top: 2%;">
                                                            <button type="submit" class="form-control btn btn-danger"
                                                                    id="button_<?php echo $comment->getMessageId() ?>"
                                                                    name="submit_answer">Submit
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="commentator_id"
                                                           value="<?php echo $_user->getUserId() ?>">
                                                    <input type="hidden" name="item_id"
                                                           value="<?php echo $item->getItemId() ?>">
                                                    <input type="hidden" name="first_message"
                                                           value="<?php echo $first_message; ?>">
                                                </form>
                                            </div>
                                            <script>
                                                $("#editor_answer_<?php echo $comment->getMessageId();?>").click(function () {
                                                    $("#editor_<?php echo $comment->getMessageId();?>").toggle();
                                                });
                                            </script>
                                        </li>
                                    </ul>

                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    <?php }
                    $counter++;
                    ?>

                <?php } ?>
            <?php }
            ?>

            <?php
            //add that sub message thread to the array 
            $sub_comments_checked_array[] = $sub_messages_thread_id;
        }
        ?>
        <?php
    }
    ?>

    <div class="cmt col-lg-8 col-lg-offset-4">
        <!-- Pagination -->
        <ul class="pagination pull-right">
            <li>
                <a href="#">&laquo;</a>
            </li>
            <li>
                <a href="#">1</a>
            </li>
            <li class="active">
                <a href="#">2</a>
            </li>
            <li>
                <a href="#">3</a>
            </li>
            <li>
                <a href="#">4</a>
            </li>
            <li>
                <a href="#">5</a>
            </li>
            <li>
                <a href="#">&raquo;</a>
            </li>
        </ul>
    </div>
</div>
