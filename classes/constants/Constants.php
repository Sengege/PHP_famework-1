<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 23/03/2016
 * Time: 14:12
 * @link https://github.com/panique/php-login-advanced
 */

// login & registration classes
define("MESSAGE_ACCOUNT_NOT_ACTIVATED", "Your account is not activated yet. Please click on the confirm link in the mail.");
define("MESSAGE_CAPTCHA_WRONG", "Captcha was wrong!");
define("MESSAGE_COOKIE_INVALID", "Invalid cookie");
define("MESSAGE_DATABASE_ERROR", "Database connection problem.");
define("MESSAGE_EMAIL_ALREADY_EXISTS", "This email address is already registered. Please use the \"I forgot my password\" page if you don't remember it.");
define("MESSAGE_EMAIL_CHANGE_FAILED", "Sorry, your email changing failed.");
define("MESSAGE_EMAIL_CHANGED_SUCCESSFULLY", "Your email address has been changed successfully. New email address is ");
define("MESSAGE_EMAIL_EMPTY", "Email cannot be empty");
define("MESSAGE_EMAIL_INVALID", "Your email address is not in a valid email format");
define("MESSAGE_EMAIL_SAME_LIKE_OLD_ONE", "Sorry, that email address is the same as your current one. Please choose another one.");
define("MESSAGE_EMAIL_TOO_LONG", "Email cannot be longer than 64 characters");
define("MESSAGE_LINK_PARAMETER_EMPTY", "Empty link parameter data.");
define("MESSAGE_LOGGED_OUT", "You have been logged out.");

// The "login failed"-message is a security improved feedback that doesn't show a potential attacker if the user exists or not
define("MESSAGE_LOGIN_FAILED", "Login failed.");
define("MESSAGE_OLD_PASSWORD_WRONG", "Your OLD password was wrong.");
define("MESSAGE_PASSWORD_BAD_CONFIRM", "Password and password repeat are not the same");
define("MESSAGE_PASSWORD_CHANGE_FAILED", "Sorry, your password changing failed.");
define("MESSAGE_PASSWORD_CHANGED_SUCCESSFULLY", "Password successfully changed!");
define("MESSAGE_PASSWORD_EMPTY", "Password field was empty");
define("MESSAGE_PASSWORD_RESET_MAIL_FAILED", "Password reset mail NOT successfully sent! Error: ");
define("MESSAGE_PASSWORD_RESET_MAIL_SUCCESSFULLY_SENT", "Password reset mail successfully sent!");
define("MESSAGE_PASSWORD_TOO_SHORT", "Password has a minimum length of 6 characters");
define("MESSAGE_PASSWORD_WRONG", "Wrong password. Try again.");
define("MESSAGE_PASSWORD_WRONG_3_TIMES", "You have entered an incorrect password 3 or more times already. Please wait 30 seconds to try again.");
define("MESSAGE_REGISTRATION_ACTIVATION_NOT_SUCCESSFUL", "Sorry, no such id/verification code combination here...");
define("MESSAGE_REGISTRATION_ACTIVATION_SUCCESSFUL", "Activation was successful! You can now log in!");
define("MESSAGE_REGISTRATION_FAILED", "Sorry, your registration failed. Please go back and try again.");
define("MESSAGE_RESET_LINK_HAS_EXPIRED", "Your reset link has expired. Please use the reset link within one hour.");
define("MESSAGE_VERIFICATION_MAIL_ERROR", "Sorry, we could not send you an verification mail. Your account has NOT been created.");
define("MESSAGE_VERIFICATION_MAIL_NOT_SENT", "Verification Mail NOT successfully sent! Error: ");
define("MESSAGE_VERIFICATION_MAIL_SENT", "Your account has been created successfully and we have sent you an email. Please click the VERIFICATION LINK within that mail.");
define("MESSAGE_USER_DOES_NOT_EXIST", "This user does not exist");
define("MESSAGE_USERNAME_BAD_LENGTH", "Username cannot be shorter than 2 or longer than 64 characters");
define("MESSAGE_USERNAME_CHANGE_FAILED", "Sorry, your chosen username renaming failed");
define("MESSAGE_USERNAME_CHANGED_SUCCESSFULLY", "Your username has been changed successfully. New username is ");
define("MESSAGE_USERNAME_EMPTY", "Username field was empty");
define("MESSAGE_USERNAME_EXISTS", "Sorry, that username is already taken. Please choose another one.");
define("MESSAGE_USERNAME_INVALID", "Username does not fit the name scheme: only a-Z and numbers are allowed, 2 to 64 characters");
define("MESSAGE_USERNAME_SAME_LIKE_OLD_ONE", "Sorry, that username is the same as your current one. Please choose another one.");

//Swope messages
define("REMOVED_FROM_WISH_LIST", "Removed from the wish list");
define("ADDED_TO_WISH_LIST", "Added to wish list");
define('CHANGES_SAVED', 'Changes saved');

//Swope errors
define('GENERIC_ERROR', 'We could not complete requested task');
define('TEXT_AREA_EMPTY', 'Please fill in text area');

//Database schema constants
define("USERS_TABLE", 'USERS');
define("ITEMS_TABLE", 'ITEM');
define("SKILL_TABLE", 'SKILL');
define("USER_SKILLS_TABLE", 'USER_SKILLS');
define('ITEM_STATUS_TABLE', 'ITEM_STATUS');
define('ITEM_CATEGORY_TABLE', 'ITEM_CATEGORY');
define('ITEM_VALUE_TABLE', 'ITEM_VALUE');
define('ITEM_SUB_CATEGORY_TABLE', 'ITEM_SUB_CATEGORY');
define('WISH_LIST_TABLE', 'WISH_LIST');
define('EXCHANGE_TABLE', 'EXCHANGE');
define('MESSAGE_TABLE', 'MESSAGE');
define('MESSAGE_THREAD_TABLE', 'MESSAGE_THREAD');
define('REVIEWS_TABLE', 'REVIEWS');

define('THUMBS_UP', 1);
define('THUMBS_DOWN', 0);

define('SUB_CAT_ITEM_OTHER', 6);
define('SUB_CAT_SKILL_OTHER', 12);
define('SUB_CAT_EXP_OTHER', 18);

define('CAT_TYPE_ITEM', 1);
define('CAT_TYPE_SKILL', 2);
define('CAT_TYPE_EXPERIENCE', 3);

define('ITEM_STATUS_NOT_FINISHED', 1);
define('ITEM_STATUS_LIVE', 2);
define('ITEM_STATUS_DELETED', 3);

define('EXCHANGE_STATUS_OFFERED', 4);
define('EXCHANGE_STATUS_ACCEPTED', 5);
define('EXCHANGE_STATUS_DECLINED', 6);
define('EXCHANGE_STATUS_PENDING', 7);
define('EXCHANGE_STATUS_REJECTED', 8);
define('EXCHANGE_STATUS_COMPLETED', 9);
define('EXCHANGE_STATUS_EVALUATED', 10);

define('MESSAGE_LOGGED_OUT_INDEX', 1);
define('GENERIC_ERROR_INDEX', 2);
define('MESSAGE_PASSWORD_EMPTY_INDEX', 5);
define('MESSAGE_PASSWORD_BAD_CONFIRM_INDEX', 6);
define('MESSAGE_PASSWORD_TOO_SHORT_INDEX', 7);
define('MESSAGE_PASSWORD_CHANGE_FAILED_INDEX', 8);
define('MESSAGE_OLD_PASSWORD_WRONG_INDEX', 9);
define('MESSAGE_SENT_INDEX', 10);
define('TEXT_AREA_EMPTY_INDEX', 11);
define('SERVER_PICTURE_FOLDER_ERROR_INDEX', 12);

define('USER_BANNED_ERROR_INDEX', 10);
define('MESSAGE_DETAILS_UPDATED_INDEX', 3);

define('MESSAGE_SENT', 'Message sent!');
define('USER_BANNED_ERROR', 'You have been banned and cannot login anymore');
define('SERVER_PICTURE_FOLDER_ERROR', "Failed to allocate space for picture.");
define('MESSAGE_DETAILS_UPDATED', 'Your changes have been saved');

define("ITEM", 'ITEM');
define("SKILL", 'SKILL');
define("EXPERIENCE", 'EXPERIENCE');
define("CLOTHES", 'CLOTHES');
define("BOOKS", 'BOOKS');
define('ELECTRONICS', 'ELECTRONICS');
define('FURNITURE', 'FURNITURE');
define('GAMES', 'GAMES');
define('ACADEMIC', 'ACADEMIC');
define('COMPUTER', 'COMPUTER');
define('ARTISTIC', 'ARTISTIC');
define('COOKING', 'COOKING');
define('LANGUAGES', 'LANGUAGES');
define('TRAVEL', 'TRAVEL');
define('FOOD', 'FOOD');
define('HISTORY', 'HISTORY');
define('FITNESS', 'FITNESS');
define('CULTURE', 'CULTURE');
define("OTHER", 'OTHER');

define('NOT_FINISHED', 'NOT_FINISHED');
define('LIVE', 'LIVE');
define('DELETED', 'DELETED');

define('OFFERED', 'OFFERED');
define('ACCEPTED', 'ACCEPTED');
define('DECLINED', 'DECLINED');
define('PENDING', 'PENDING');
define('REJECTED', 'REJECTED');
define('COMPLETED', 'COMPLETED');

//path to images
define("IMAGES_PATH", '/var/www/secure/images/');
define("MAX_IMAGE_SIZE", 2000000);
define('DEFAULT_CATEGORY_TYPE', 1);
define('DEFAULT_ITEM_VALUE_TYPE', 2);
define('DEFAULT_ITEMS_LIMIT_PAGE', 8);

