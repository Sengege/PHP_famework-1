<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 23/03/2016
 * Time: 13:37
 *
 * Handles registration
 * @link http://www.php-login.net
 * @link https://github.com/panique/php-login-advanced/
 * @license http://opensource.org/licenses/MIT MIT License
 */

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/config/config.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/classes/db_handlers/Database.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/classes/db_handlers/Model.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/classes/constants/Constants.php');
require(realpath($_SERVER["DOCUMENT_ROOT"]) .'/classes/libs/PHPMailer/PHPMailerAutoload.php');

class Registration{

    /**
     * @var int registration verification number
     */
    private $user_activation_hash = null;

    /**
     * @return int
     */
    public function getUserActivationHash()
    {
        return $this->user_activation_hash;
    }
    /**
     * @var integer gets registered user id
     */
    private $user_id = null;

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->user_id;
    }
    /**
     * @var bool doesn't send email if true
     */
    private $debug = true;

    /**
     * @var Database handles database connection
     */
    private $db_connection = null;
    /**
     * @var Model handles CRUD operations
     */
    private $db_model = null;
    /**
     * @var boolean for successful registration
     */
    public  $registration_successful  = false;
    /**
     * @var boolean state of verification
     */
    public $verification_successful = false;
    /**
     * @var array of error messages
     */
    public $errors = array();
    /**
     * @var array of success/neutral messages
     */
    public $messages = array();

    public function __construct(){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }


        //set up DB connection
        echo "PHP Registration construct<br>";
        $this->db_connection = Database::getInstance();
        $this->db_model = new Model($this->db_connection);

        if(isset($_POST["submitEN"])){
            $this->registerNewUser($_POST['usernameEN'], $_POST['emailEN'], $_POST['passwordEN'], $_POST['confirm_passwordEN']);
        } else if(isset($_POST["submitCN"])){
            $this->registerNewUser($_POST['usernameCN'], $_POST['emailCN'], $_POST['passwordCN'], $_POST['confirm_passwordCN']);
        } else if (isset($_GET["id"])){
            $this->verifyNewUser($_GET["id"]);
        }
    }

    /**
     * Handles registration
     *
     * @param $username
     * @param $email
     * @param $password
     * @param $confirm_password
     */
    private function registerNewUser($username, $email, $password, $confirm_password)
    {
        //remove extra space
        $username = trim($username);
        $email = trim($email);
        $password = trim($password);
        $confirm_password = trim($confirm_password);

        // check provided data validity
        // TODO: check for "return true" case early, so put this first
        if (empty($username)) {
            $this->errors[] = MESSAGE_USERNAME_EMPTY;
        } elseif (empty($password) || empty($confirm_password)) {
            $this->errors[] = MESSAGE_PASSWORD_EMPTY;
        } elseif ($password !== $confirm_password) {
            $this->errors[] = MESSAGE_PASSWORD_BAD_CONFIRM;
        } elseif (strlen($password) < 6) {
            $this->errors[] = MESSAGE_PASSWORD_TOO_SHORT;
        } elseif (strlen($username) > 64 || strlen($username) < 2) {
            $this->errors[] = MESSAGE_USERNAME_BAD_LENGTH;
        }
        /*elseif (!preg_match('/^[a-z\d]{2,64}$/i', $username)) {
            $this->errors[] = MESSAGE_USERNAME_INVALID;
        } */
        elseif (empty($email)) {
            $this->errors[] = MESSAGE_EMAIL_EMPTY;
        } elseif (strlen($email) > 64) {
            $this->errors[] = MESSAGE_EMAIL_TOO_LONG;
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = MESSAGE_EMAIL_INVALID;
            // finally if all the above checks are ok
        } else if ($this->db_connection != null){
            //check if username or email already exists
            $resultUsername = $this->db_model->read(USERS_TABLE, 'username', $username);
            $resultEmail = $this->db_model->read(USERS_TABLE, 'email', $email);

            if((count($resultUsername) > 0)){
                $this->errors[] =  MESSAGE_USERNAME_EXISTS;
            } else if (count($resultEmail) > 0) {
                $this->errors[] = MESSAGE_EMAIL_ALREADY_EXISTS;
            } else {
                // check if we have a constant HASH_COST_FACTOR defined (in config/hashing.php),
                // if so: put the value into $hash_cost_factor, if not, make $hash_cost_factor = null
                $hash_cost_factor = (defined('HASH_COST_FACTOR') ? HASH_COST_FACTOR : null);

                // crypt the user's password with the PHP 5.5's password_hash() function, results in a 60 character hash string
                // the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using PHP 5.3/5.4, by the password hashing
                // compatibility library. the third parameter looks a little bit shitty, but that's how those PHP 5.5 functions
                // want the parameter: as an array with, currently only used with 'cost' => XX.
                $user_password_hash = password_hash($password, PASSWORD_DEFAULT, array('cost' => $hash_cost_factor));
                // generate random hash for email verification (40 char string)
                $this->user_activation_hash = sha1(uniqid(mt_rand(), true));

                //write new user into DB
                $values = array('username' => $username, 'email' => $email, 'password' => $user_password_hash, 'confirmation_key' => $this->user_activation_hash);
                $result = $this->db_model->insert(USERS_TABLE, $values);

                // id of new user
                $this->user_id = $this->db_model->getDb()->getLastId();


                if($result){

                    if($this->debug){
                        $this->messages[] = MESSAGE_VERIFICATION_MAIL_SENT;
                        $this->registration_successful = true;
                    }else {
                        if($this->sendVerificationEmail($this->user_id,$username, $email, $this->user_activation_hash)){
                            // when mail has been send successfully
                            $this->messages[] = MESSAGE_VERIFICATION_MAIL_SENT;
                            $this->registration_successful = true;
                        } else {
                            //delete user if no email sent
                            $this->db_model->delete(USERS_TABLE, 'username', $username);
                            $this->errors[] = MESSAGE_VERIFICATION_MAIL_ERROR;
                            $this->registration_successful = false;
                        }
                    }

                } else {
                    $this->errors[] = $result;
                }
            }
        }
    }

    private function verifyNewUser($id)
    {
    }

    private function sendVerificationEmail($user_id, $username, $email, $user_activation_hash)
    {
        $mail = new PHPMailer;
        // please look into the config/config.php for much more info on how to use this!
        // use SMTP or use mail()
        if (EMAIL_USE_SMTP) {
            // Set mailer to use SMTP
            $mail->IsSMTP();
            //useful for debugging, shows full SMTP errors
            $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
            // Enable SMTP authentication
            $mail->SMTPAuth = EMAIL_SMTP_AUTH;
            // Enable encryption, usually SSL/TLS
            if (defined(EMAIL_SMTP_ENCRYPTION)) {
                $mail->SMTPSecure = EMAIL_SMTP_ENCRYPTION;
            }
            // Specify host server
            $mail->Host = EMAIL_SMTP_HOST;
            $mail->Username = EMAIL_SMTP_USERNAME;
            $mail->Password = EMAIL_SMTP_PASSWORD;
            $mail->Port = EMAIL_SMTP_PORT;
        } else {
            $mail->IsMail();
        }
        $mail->isHTML(true);
        $mail->WordWrap = 50;
        $mail->From = EMAIL_VERIFICATION_FROM;
        $mail->FromName = EMAIL_VERIFICATION_FROM_NAME;
        $mail->AddAddress($email);
        $mail->Subject = EMAIL_VERIFICATION_SUBJECT;
        $link = EMAIL_VERIFICATION_URL.'?user_id='.urlencode($user_id).'&verification_code='.urlencode($user_activation_hash);
        // the link to your register.php, please set this value in config/email_verification.php
        $mail->Body = EMAIL_VERIFICATION_CONTENT.' '.$link;
        if(!$mail->send()) {
            $this->errors[] = MESSAGE_VERIFICATION_MAIL_NOT_SENT . $mail->ErrorInfo;
            return false;
        } else {
            return true;
        }
    }
    
}

