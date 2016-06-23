<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/classes/db_handlers/Database.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/classes/db_handlers/Model.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/classes/constants/Constants.php');
/**
 * Created by PhpStorm.
 * User: adamkisala
 * Date: 30/04/2016
 * Time: 11:43
 */
class SkillsCollection
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
    
    public function __construct()
    {
        $this->db_connection = Database::getInstance();
        $this->db_model = new Model($this->db_connection);
    }
    
    public function getGeneralSkills(){
        return $this->db_model->read(SKILL_TABLE, 'is_general', 1);
    }
    
    public function getSkillById($skill_id){
        return $this->db_model->readFirst(SKILL_TABLE, 'skill_id', $skill_id);
    }
    public function getUserSkills($user_id){
        return $this->db_model->read(USER_SKILLS_TABLE, 'user_id', $user_id);
    }
}