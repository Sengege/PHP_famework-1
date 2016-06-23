<?php

/**
 * Created by PhpStorm.
 * User: adamkisala
 * Date: 05/05/2016
 * Time: 10:53
 */

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/constants/Constants.php');

class ErrorsController
{
    public static function getError($index)
    {
        switch ($index) {
            case MESSAGE_LOGGED_OUT_INDEX:
                return MESSAGE_LOGGED_OUT;
                break;
            case GENERIC_ERROR_INDEX:
                return GENERIC_ERROR;
                break;
            case 3:
                return MESSAGE_LOGIN_FAILED;
                break;
            case TEXT_AREA_EMPTY_INDEX:
                return TEXT_AREA_EMPTY;
                break;
            case MESSAGE_PASSWORD_EMPTY_INDEX:
                return MESSAGE_PASSWORD_EMPTY;
                break;
            case MESSAGE_PASSWORD_BAD_CONFIRM_INDEX:
                return MESSAGE_PASSWORD_BAD_CONFIRM;
                break;
            case MESSAGE_PASSWORD_TOO_SHORT_INDEX:
                return MESSAGE_PASSWORD_TOO_SHORT;
                break;
            case MESSAGE_PASSWORD_CHANGE_FAILED_INDEX:
                return MESSAGE_PASSWORD_CHANGE_FAILED;
                break;
            case MESSAGE_OLD_PASSWORD_WRONG_INDEX:
                return MESSAGE_OLD_PASSWORD_WRONG;
                break;
            case USER_BANNED_ERROR_INDEX:
                return USER_BANNED_ERROR;
                break;
            case SERVER_PICTURE_FOLDER_ERROR_INDEX:
                return SERVER_PICTURE_FOLDER_ERROR;
                break;
            default:
                return '';
                break;
        }
    }
}