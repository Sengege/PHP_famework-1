<?php

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/classes/db_handlers/Database.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/classes/db_handlers/Model.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/classes/constants/Constants.php');

/**
 * Created by PhpStorm.
 * User: adamkisala
 * Date: 13/04/2016
 * Time: 00:27
 */
class ItemsCollection
{
    /**
     * @var array
     */
    private $collection = array();
    /**
     * @var Model|null
     */
    private $db_model = null;
    /**
     * @var Database|null
     */
    private $db_connection = null;

    public function __construct(){
        $this->db_connection = Database::getInstance();
        $this->db_model = new Model($this->db_connection);
    }

    /**
     * @return array of most recent items
     */
    public function getMostRecentItems($limit = DEFAULT_ITEMS_LIMIT_PAGE){

        $query = 'SELECT *	FROM ITEM
								WHERE date_time >= NOW() - INTERVAL 3 MONTH ORDER BY date_time DESC LIMIT ' . $limit;
        return $items = $this->db_connection->query($query);
    }

    /**
     * @param $user_id
     * @return array of items that belong to the user
     */
    public function getItemsByUserId($user_id){
        return $this->db_model->read(ITEMS_TABLE, 'user_id', $user_id);
    }
    
    
 
    /**
     * @param $category
     * @return array of items sorted by category
     */
    public function getItemsByCategory($category){
        return $this->db_model->read(ITEMS_TABLE, 'category_type_id', $category);
    }

    /**
     * @param $tag
     * @return array of items sorted by tag
     */
    public function getItemsByTag($tag){

    }
    
  

}