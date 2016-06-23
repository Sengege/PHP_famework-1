<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 23/03/2016
 * Time: 13:21
 */
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Model.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/db_handlers/Database.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/classes/constants/Constants.php');


/**
 * Class User
 */
class User{


    private $banned = null;
    /**
     * @var null
     */
    private $likes = null;
    /**
     * @var null
     */
    private $dislikes = null;

    /**
     * @return null
     */
    public function getDislikes()
    {
        return $this->dislikes;
    }

    /**
     * @param null $dislikes
     */
    public function setDislikes($dislikes)
    {
        $this->dislikes = $dislikes;
    }

    /**
     * @return null
     */
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * @param null $likes
     */
    public function setLikes($likes)
    {
        $this->likes = $likes;
    }
    /**
     * @var int
     */
    private $user_id = -1;

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }
    /**
     * @var string
     */
    private $name = "";
    /**
     * @var string
     */
    private $password = "";
    /**
     * @var string
     */
    private $location = "";
    /**
     * @var string
     */
    private $email = "";
    /**
     * @var int
     */
    private $contact_no = 0;
    /**
     * @var string
     */
    private $university = "";
    /**
     * @var string
     */
    private $profile_pic = "";
    /**
     * @var string
     */
    private $description = "";
    /**
     * @var int
     */
    private $registered = -1;
    /**
     * @var int
     */
    private $confirmation_key = -1;
    /**
     * @var bool
     */
    private $user_is_logged_in = false;
    
    /**
     * User constructor.
     */
    public function __construct(){
        
    }

    /**
     * @param $user_id
     * @return User
     */
    public static function __constructWithIdFromDB($user_id){
        $instance = new self();
        $db_connection = Database::getInstance();
        $db_model = new Model($db_connection);
        $user = $db_model->readFirst(USERS_TABLE, 'user_id', (integer)$user_id);
        if($user){
            $instance->user_id = $user['user_id'];
            $instance->name = $user['username'];
            $instance->location = $user['location'];
            $instance->email = $user['email'];
            $instance->contact_no = $user['contact_no'];
            $instance->university = $user['university'];
            $instance->profile_pic = $user['profile_pic'];
            $instance->description = $user['description'];
            $instance->registered = $user['registered'];
            $instance->confirmation_key = $user['confirmation_key'];
            $instance->likes = $user['likes'];
            $instance->dislikes = $user['dislikes'];
            $instance->password = $user['password'];
            $instance->banned = $user['banned'];
        }

        return $instance;
    }
    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getRegistered()
    {
        return $this->registered;
    }

    /**
     * @param int $registered
     */
    public function setRegistered($registered)
    {
        $this->registered = $registered;
    }

    /**
     * @return int
     */
    public function getConfirmationKey()
    {
        return $this->confirmation_key;
    }

    /**
     * @param int $confirmation_key
     */
    public function setConfirmationKey($confirmation_key)
    {
        $this->confirmation_key = $confirmation_key;
    }

    /**
     * @return boolean
     */
    public function isUserIsLoggedIn()
    {
        return $this->user_is_logged_in;
    }

    /**
     * @param boolean $user_is_logged_in
     */
    public function setUserIsLoggedIn($user_is_logged_in)
    {
        $this->user_is_logged_in = $user_is_logged_in;
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
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param null $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return null
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param null $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param null $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return null
     */
    public function getContactNo()
    {
        return $this->contact_no;
    }

    /**
     * @param null $contact_no
     */
    public function setContactNo($contact_no)
    {
        $this->contact_no = $contact_no;
    }

    /**
     * @return null
     */
    public function getUniversity()
    {
        return $this->university;
    }

    /**
     * @param null $university
     */
    public function setUniversity($university)
    {
        $this->university = $university;
    }

    /**
     * @return null
     */
    public function getProfilePic()
    {
        return $this->profile_pic;
    }

    /**
     * @param null $profile_pic
     */
    public function setProfilePic($profile_pic)
    {
        $this->profile_pic = $profile_pic;
    }

    /**
     * @return null
     */
    public function getBanned()
    {
        return $this->banned;
    }

    /**
     * @param null $banned
     */
    public function setBanned($banned)
    {
        $this->banned = $banned;
    }

}