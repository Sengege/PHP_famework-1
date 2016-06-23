<?php
/**
 * Created by PhpStorm.
 * User: adamkisala
 * Date: 24/05/2016
 * Time: 11:15
 */

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/helpers/functions.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/models/User.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Model.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Database.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/constants/Constants.php');
if (isset($_SESSION['user_id'])) {
    $db_connection = Database::getInstance();
    $db_model = new Model($db_connection);

    if (isset($_POST['change_password_submit'])) {
        $user_password_old = $_POST['old_password'];
        $user_password_new = $_POST['new_password'];
        $user_password_repeat = $_POST['new_password_repeat'];

        if (empty($user_password_new) || empty($user_password_repeat) || empty($user_password_old)) {
            redirect_to(PATH_TO_VIEWS . 'edit_profile.php?error=' . MESSAGE_PASSWORD_EMPTY_INDEX);
            // is the repeat password identical to password
        } elseif ($user_password_new !== $user_password_repeat) {
            redirect_to(PATH_TO_VIEWS . 'edit_profile.php?error=' . MESSAGE_PASSWORD_BAD_CONFIRM_INDEX);
            // password need to have a minimum length of 6 characters
        } elseif (strlen($user_password_new) < 6) {
            redirect_to(PATH_TO_VIEWS . 'edit_profile.php?error=' . MESSAGE_PASSWORD_TOO_SHORT_INDEX);
            // all the above tests are ok
        } else {
            // database query, getting hash of currently logged in user (to check with just provided password)

            $user = User::__constructWithIdFromDB($_SESSION['user_id']);
            // if this user exists
            if ($user->getPassword() != null) {

                // using PHP 5.5's password_verify() function to check if the provided passwords fits to the hash of that user's password
                if (password_verify($user_password_old, $user->getPassword())) {

                    // now it gets a little bit crazy: check if we have a constant HASH_COST_FACTOR defined (in config/hashing.php),
                    // if so: put the value into $hash_cost_factor, if not, make $hash_cost_factor = null
                    $hash_cost_factor = (defined('HASH_COST_FACTOR') ? HASH_COST_FACTOR : null);

                    // crypt the user's password with the PHP 5.5's password_hash() function, results in a 60 character hash string
                    // the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using PHP 5.3/5.4, by the password hashing
                    // compatibility library. the third parameter looks a little bit shitty, but that's how those PHP 5.5 functions
                    // want the parameter: as an array with, currently only used with 'cost' => XX.
                    $user_password_hash = password_hash($user_password_new, PASSWORD_DEFAULT, array('cost' => $hash_cost_factor));

                    $values = array('password'=>$user_password_hash);
                    // write users new hash into database
                    $result = $db_model->update(USERS_TABLE, 'user_id', $user->getUserId(), $values);

                    // check if exactly one row was successfully changed:
                    if ($result && !empty($result)) {
                        redirect_to(PATH_TO_VIEWS . 'edit_profile.php?message=1');
                    } else {
                        redirect_to(PATH_TO_VIEWS . 'edit_profile.php?error=' . MESSAGE_PASSWORD_CHANGE_FAILED_INDEX);
                    }
                } else {
                    redirect_to(PATH_TO_VIEWS . 'edit_profile.php?error=' . MESSAGE_OLD_PASSWORD_WRONG_INDEX);
                }
            } else {
                redirect_to(PATH_TO_VIEWS . 'edit_profile.php?error=2');
            }
        }

        redirect_to(PATH_TO_VIEWS . 'edit_profile.php?message=1');
    } else {
        redirect_to(PATH_TO_VIEWS . 'edit_profile.php?error=1');
    }
}