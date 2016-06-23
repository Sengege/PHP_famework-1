<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 22/03/2016
 * Time: 22:23
 *
 * This class creates and maintains connection with database
 * Providing at the same time API for queries.
 * Based on https://github.com/mRoca/slim-boilerplate/
 */
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/config/config.php');
//require_once '../../config/config.php';
require_once 'DB_Exception.php';


class Database{

    /** @var Database*/
    private static $singleton = null;
    protected $type = DB_TYPE;
    protected $host = DB_HOST;
    protected $base = DB_NAME;
    protected $user = DB_USER;
    protected $password = DB_PASS;
    protected $connectionDone = false;

    /** @var PDO */
    protected $pdoObject = null;

    private function __construct(){

    }

    /** Get instance of the database
     *  @return Database
     */
    public static function getInstance(){
        if(self::$singleton === null){
            self::$singleton = new self();
        }
        return self::$singleton;
    }

    /**
     * Execute the PDO 'query' function => SELECT
     *
     * Example: $db->query('SELECT * FROM table WHERE name = ? AND firstname = ?', array('My Name', 'My firstname'));
     * Example: $db->query('SELECT * FROM table WHERE name = :name AND firstname = :firstname', array('name' => 'My Name', 'firstname' => 'My firstname'));
     *
     * @param string $sql
     * @param array $values
     * @return array
     */
    public function query($sql, $values = array()){
        if(!$this->isConnectionDone()){
            $this->connection();
        }
        try{
            if(!is_array($values)){
                $values = array($values);
            }
            if(count($values) > 0){
                $req = $this->pdoObject->prepare($sql);
                $req->execute($values);
                return $req->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return $this->pdoObject->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e){
            $this->error($e->getMessage());
            return array();
        }
    }

    /** @return boolean*/
    public function isConnectionDone(){
        return $this->connectionDone;
    }

    /**
     * Connect to the database
     *
     * @return boolean
     */
    public function connection(){
        try{
            $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
            $this->pdoObject = new PDO($this->type . ':host=' . $this->host . ';dbname=' . $this->base . '', $this->user, $this->password, $pdo_options);
            $this->connectionDone = true;
            return true;
        } catch (Exception $e){
            $this->connectionDone = false;
            $this->error($e->getMessage());
            return false;
        }
    }

    /**
     * Display an error
     *
     * @param $getMessage
     * @throws DB_Exception
     */
    protected function error($getMessage){
        throw new DB_Exception('Database error : ' . $getMessage);
    }

    /**
     * Execute the PDO 'exec' function => INSERT, UPDATE adn DELETE
     *
     * Example: $db->exec('UPDATE table SET name = ? WHERE id = ?', array('My True Name', 1));
     * Example: $db->exec('UPDATE table SET name = :name WHERE id = :id', array('name' => 'My True Name', 'id' => 1));
     * Example: $db->exec('DELETE FROM table WHERE id = :id', array('id' => 1));
     *
     * @param string $sql
     * @param array $values
     *
     * @return bool|int
     */
    public function exec($sql, $values = array()){
        if(!$this->isConnectionDone()){
            $this->connection();
        }

        try{
            if(is_array($values) && count($values) > 0){
                $req = $this->pdoObject->prepare($sql);
                return $req->execute($values);
            } else {
                return $this->pdoObject->exec($sql);
            }
        } catch (Exception $e){
            $this->error($e->getMessage());
            return false;
        }
    }

    /**
     * Read the $binaryFields files contents and execute the PDO 'execute' function with this blobs => INSERT and UPDATE
     *
     * Example: $db->exec('INSERT INTO table (name, image) VALUES (:name, :imagefile)', array('name' => 'The Name'), array('imagefile' => '/tmp/img.jpg'));
     *
     * @param string $sql
     * @param array $textFields
     * @param array $binaryFields
     * @return bool|int|string
     */
    public function executeWithBinaryFiles($sql, $textFields = array(), $binaryFields = array()){
        if(!$this->isConnectionDone()){
            $this->connection();
        }
        try{
            $req = $this->pdoObject->prepare($sql);

            foreach($binaryFields as $key => $value){
                $fic = fopen($value, 'rb');
                $req->bindParam($key, $fic, PDO::PARAM_LOB);
            }

            foreach($textFields as $key => &$value){
                $req->bindParam($key, $value);
            }

            if($req->execute()){
                return $this->pdoObject->lastInsertId();
            }

            return false;
        } catch (\Exception $e){
            $this->error($e->getMessage());
            return false;
        }
    }

    public function getLastId(){
        return $this->pdoObject->lastInsertId();
    }
}