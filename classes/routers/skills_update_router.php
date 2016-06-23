<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
/**
 * Created by PhpStorm.
 * User: adamkisala
 * Date: 30/04/2016
 * Time: 14:25
 */

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/helpers/functions.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/models/User.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Model.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Database.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/constants/Constants.php');

$db_connection = Database::getInstance();
$db_model = new Model($db_connection);

$TRUE = "true";
$FALSE = "false";

if(!isset($_SESSION["user_id"])){
    //well that's embarrassing
    return;
} else {
    if (isset($_POST['delete_skill_id'])){
        $skill_id = $_POST['delete_skill_id'];
        $db_model->deleteTwoKeys(USER_SKILLS_TABLE, 'skill_id', 'user_id', $skill_id, $_SESSION["user_id"]);
        echo $TRUE;
    } else if (isset($_POST['add_skill_id']) && isset($_POST['add_skill_name'])) {
        $skill_id = $_POST['add_skill_id'];
        $skill_name = $_POST['add_skill_name'];
        if($skill_id < 0 || empty($skill_id)){

            //check if entered skill already exists in the DB with the same name
            $skill_exists = $db_model->readFirst(SKILL_TABLE, 'skill_name', $skill_name);
            if($skill_exists){
                //check if already in USER_SKILLS table if not enter into to USER_SKILLS table
                $user_skill_exists = $db_model->readFirst(USER_SKILLS_TABLE, 'skill_id', $skill_exists['skill_id']);
                if (!$user_skill_exists){
                    //update USER_SKILLS table
                    $values = array('skill_id'=>$skill_exists['skill_id'], 'user_id'=>$_SESSION["user_id"]);
                    $db_model->insert(USER_SKILLS_TABLE, $values);
                    echo $TRUE;
                } else {
                    //user skill like that already exists in USER_SKILLS table
                    echo $FALSE;
                }
                
            } else {
                //skill like that doesn't exist yet in SKILLS table add it to SKILL table and USER_SKILLS
                $values = array('skill_name'=>$skill_name, 'is_general'=>0);
                $db_model->insert(SKILL_TABLE, $values);
                
                //get ID just inserted
                $just_inserted_id = $db_model->getDb()->getLastId();
                $user_skills = array('skill_id'=>$just_inserted_id, 'user_id'=>$_SESSION["user_id"]);
                $db_model->insert(USER_SKILLS_TABLE, $user_skills);
                echo $TRUE;
            }

        } else {
            $user_skills = $db_model->read(USER_SKILLS_TABLE, 'user_id', $_SESSION["user_id"]);
            $has_that_skill_already = false;
            if(count($user_skills) > 0){
                foreach ($user_skills as $user_skill){
                    if($user_skill['skill_id'] === $skill_id){
                        $has_that_skill_already = true;
                        echo $FALSE . " user skill already in the USER_SKILLS_TABLE";
                        return;
                    }
                }
            }
            if(!$has_that_skill_already){
                $values = array('skill_id'=>$skill_id, 'user_id'=>$_SESSION['user_id']);
                $db_model->insert(USER_SKILLS_TABLE, $values);
                echo $TRUE;
            }
            
        }
    }
}

