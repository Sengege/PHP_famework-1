<?php

/**
 * Created by PhpStorm.
 * User: adamkisala
 * Date: 16/05/2016
 * Time: 13:42
 */

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/constants/Constants.php');

class InfoMessageController
{
    public static function getMessage($index)
    {
        switch ($index) {
            case 1:
                return CHANGES_SAVED;
                break;
            case MESSAGE_SENT_INDEX:
                return MESSAGE_SENT;
                break;
            case MESSAGE_DETAILS_UPDATED_INDEX:
                return MESSAGE_DETAILS_UPDATED;
                break;
            default:
                return '';
                break;
        }
    }

}