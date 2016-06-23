<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/collections/MessagesCollection.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/collections/ExchangeCollection.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/models/Exchange.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/models/Item.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/models/User.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/models/Message.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/models/MessageThread.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/constants/Constants.php');

$exchange_collection = new ExchangeCollection();
$exchanges_acceptor = $exchange_collection->getExchangesByAcceptor($_user->getUserId());
$exchanges_offeror = $exchange_collection->getExchangesByOfferor($_user->getUserId());

$message_threads_as_sender = MessagesCollection::getDirectMessagesThreadsByUserAsSenderOldestFirst($_user->getUserId());
$message_threads_as_receiver = MessagesCollection::getDirectMessagesThreadsByUserAsReceiverOldestFirst($_user->getUserId());

if (count($exchanges_acceptor) > 0) {
    $exchanges_acceptor_with_messages = ExchangeCollection::getExchangesWithMessageThread($exchanges_acceptor);
} else {
    $exchanges_acceptor_with_messages = array();
}

if (count($exchanges_offeror) > 0) {
    $exchanges_offeror_with_message = ExchangeCollection::getExchangesWithMessageThread($exchanges_offeror);
} else {
    $exchanges_offeror_with_message = array();
}

?>

<?php foreach ($message_threads_as_sender as $message_thread_as_sender){
    $message_thread = MessageThread::__constructWithIdFromDB($message_thread_as_sender['message_thread_id']);
    $messages = MessagesCollection::getMessagesByThreadIdOldestFirst($message_thread_as_sender['message_thread_id']);
    $s = User::__constructWithIdFromDB($message_thread->getSenderId());
    $receiver = User::__constructWithIdFromDB($message_thread->getReceiverId());
    ?>
    <?php
    $exchange_bool = false;
    include ('message_row.php');?>

<?php } ?>

<?php foreach ($message_threads_as_receiver as $message_thread_as_receiver){
    $message_thread = MessageThread::__constructWithIdFromDB($message_thread_as_receiver['message_thread_id']);
    $messages = MessagesCollection::getMessagesByThreadIdOldestFirst($message_thread_as_receiver['message_thread_id']);
    $s = User::__constructWithIdFromDB($message_thread->getSenderId());
    $receiver = User::__constructWithIdFromDB($message_thread->getReceiverId());
    ?>
    <?php
    $exchange_bool = false;
    include ('message_row.php');?>

<?php } ?>

<?php foreach ($exchanges_acceptor_with_messages as $exchange_acceptor_message) {
    $exchange = Exchange::__constructWithIdFromDB($exchange_acceptor_message['exchange_id']);
    $u = User::__constructWithIdFromDB($exchange->getUserIdOfferor());
    $messages = MessagesCollection::getMessagesByThreadIdOldestFirst($exchange->getMessageThreadId());
    ?>
    <?php
    $exchange_bool = true;
    include ('message_row.php');?>
  
<?php } ?>


<?php foreach ($exchanges_offeror_with_message as $exchange_offeror_message) {
    $exchange = Exchange::__constructWithIdFromDB($exchange_offeror_message['exchange_id']);
    $u = User::__constructWithIdFromDB($exchange->getUserIdOfferor());
    $messages = MessagesCollection::getMessagesByThreadIdOldestFirst($exchange->getMessageThreadId());
    ?>
    <?php
    $exchange_bool = true;
    include ('message_row.php');?>
    
<?php } ?>
