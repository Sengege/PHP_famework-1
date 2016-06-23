<?php

/**
 * Created by PhpStorm.
 * User: adamkisala
 * Date: 13/04/2016
 * Time: 00:08
 * Item model - database representation
 */

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Model.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Database.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/constants/Constants.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/controllers/ImageController.php');

/**
 * Class Item
 */
class Item
{
    
    private $my_category = '';

    private $value = '';
    private $wanted = '';

    private $likes = null;

    /**
     * @param null $likes
     */
    public function setLikes($likes)
    {
        $this->likes = $likes;
    }

    private $message_thread_id = null;

    /**
     * @return null
     */
    public function getMessageThreadId()
    {
        return $this->message_thread_id;
    }

    /**
     * @param null $message_thread_id
     */
    public function setMessageThreadId($message_thread_id)
    {
        $this->message_thread_id = $message_thread_id;
    }

    /**
     * @var null
     */
    private $sub_category_id = null;

    /**
     * @return null
     */
    public function getSubCategoryId()
    {
        return $this->sub_category_id;
    }

    /**
     * @param null $sub_category_id
     */
    public function setSubCategoryId($sub_category_id)
    {
        $this->sub_category_id = $sub_category_id;
    }

    /**
     * @var integer, autoincrement in the database
     */
    private $item_id = null;

    /**
     * @var integer
     */
    private $user_id = null;
    /**
     * @var string
     */
    private $category_type_id = "";
    /**
     * @var string
     */
    private $value_type_id = "";
    /**
     * @var string
     */
    private $status_type_id = "";
    /**
     * @var string
     */
    private $name = "";
    /**
     * @var string
     */
    private $description = "";
    /**
     * @var string, path to folder with item's pictures
     */
    private $photos = "";
    /**
     * @var datetime stamp
     */
    private $date_time = null;

    /**
     * @return integer
     */
    public function getItemId()
    {
        return $this->item_id;
    }

    /**
     * @param int $item_id
     */
    public function setItemId($item_id)
    {
        $this->item_id = $item_id;
    }

    /**
     * @return null
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param null $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return null
     */
    public function getCategoryTypeId()
    {
        return $this->category_type_id;
    }

    /**
     * @param null $category_type_id
     */
    public function setCategoryTypeId($category_type_id)
    {
        $this->category_type_id = $category_type_id;
    }

    /**
     * @return null
     */
    public function getValueTypeId()
    {
        return $this->value_type_id;
    }

    /**
     * @param null $value_type_id
     */
    public function setValueTypeId($value_type_id)
    {
        $this->value_type_id = $value_type_id;
    }

    /**
     * @return null
     */
    public function getStatusTypeId()
    {
        return $this->status_type_id;
    }

    /**
     * @param null $status_type_id
     */
    public function setStatusTypeId($status_type_id)
    {
        $this->status_type_id = $status_type_id;
    }

    /**
     * @return null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param null $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param null $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return null
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * @param null $photos
     */
    public function setPhotos($photos)
    {
        $this->photos = $photos;
    }

    /**
     * @return null
     */
    public function getDateTime()
    {
        return $this->date_time;
    }

    /**
     * @param null $date_time
     */
    public function setDateTime($date_time)
    {
        $this->date_time = $date_time;
    }

    /**
     * Item constructor.
     * @param $item_id
     */
    public function __construct()
    {

    }

    public static function __constructWithIdFromDB($item_id)
    {
        $instance = new self();
        $db_connection = Database::getInstance();
        $db_model = new Model($db_connection);
        $item = $db_model->readFirst(ITEMS_TABLE, "item_id", (integer)$item_id);
        if ($item) {
            $instance->item_id = $item["item_id"];
            $instance->user_id = $item["user_id"];
            $instance->category_type_id = $item["category_type_id"];
            $instance->value_type_id = $item["value_type_id"];
            $instance->status_type_id = $item["status_type_id"];
            $instance->name = $item["name"];
            $instance->description = $item["description"];
            $instance->photos = $item["photos"];
            $instance->date_time = $item["date_time"];
            $instance->sub_category_id = $item['sub_category_type_id'];
            $instance->message_thread_id = $item['message_thread_id'];
            $instance->likes = $item['likes'];
            $instance->wanted = $item['wanted'];
            $instance->value = $item['value'];
            $instance->my_category = $item['my_category'];
        }
        return $instance;
    }

    public function getPictures()
    {
        $dir = IMAGES_PATH . $this->photos . '/';
        $images = ImageController::getAllImagesFromDir($dir);
        if (count($images) > 0) {
            return $images;
        } else {
            return $images = array();
        }
    }

    public function getItemCategoryName($category_type_id)
    {
        $db_connection = Database::getInstance();
        $db_model = new Model($db_connection);
        $row = $db_model->readFirst(ITEM_CATEGORY_TABLE, 'category_type_id', $category_type_id);
        return strtolower($row['category_name']);
    }

    public function getItemSubCategoryName($sub_category_type_id)
    {
        $db_connection = Database::getInstance();
        $db_model = new Model($db_connection);
        $row = $db_model->readFirst(ITEM_SUB_CATEGORY_TABLE, 'sub_category_type_id', $sub_category_type_id);
        return strtolower($row['sub_category_name']);
    }

    public function getItemCatIdByName($category_name){
        $db_connection = Database::getInstance();
        $db_model = new Model($db_connection);
        $result = $db_model->readFirst(ITEM_CATEGORY_TABLE, 'category_name', strtoupper($category_name));
        return $result['category_type_id'];
    }

    public function getItemSubCatIdByName($sub_category_name){
        $db_connection = Database::getInstance();
        $db_model = new Model($db_connection);
        $result = $db_model->readFirst(ITEM_SUB_CATEGORY_TABLE, 'sub_category_name', strtoupper($sub_category_name));
        return $result['sub_category_type_id'];
    }
    /**
     * @return null
     */
    public function getLikes()
    {
        return $this->likes;
    }

    public function getSubcategories(){
        $db_connection = Database::getInstance();
        $db_model = new Model($db_connection);
        return $db_model->read(ITEM_SUB_CATEGORY_TABLE, 'category_type_id', $this->getCategoryTypeId());
    }

    /**
     * @return string
     */
    public function getWanted()
    {
        return $this->wanted;
    }

    /**
     * @param string $wanted
     */
    public function setWanted($wanted)
    {
        $this->wanted = $wanted;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getMyCategory()
    {
        return $this->my_category;
    }

    /**
     * @param string $my_category
     */
    public function setMyCategory($my_category)
    {
        $this->my_category = $my_category;
    }


}