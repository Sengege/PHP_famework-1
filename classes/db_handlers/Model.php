<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 22/03/2016
 * Time: 23:27
 *
 * Class to execute CRUD commands on @Database
 * Base: https://github.com/mRoca/slim-boilerplate/
 */

class Model{

    /**
     * @var Database
     */
    protected $db;

    /**
     * Model constructor.
     * @param null $db
     */
    public function __construct(& $db = null){
        $this->db = $db ? $db : Database::getInstance();
    }

    /**
     * * Do a SELECT * FROM $table WHERE $column = '$value' and return the first result
     *
     * @param $table
     * @param $column
     * @param $columnValue
     * @return array
     */
    public function readFirst($table, $column, $columnValue){
        $res = $this->read($table, $column, $columnValue, true);

        if(count($res)){
            return $res[0];
        }

        return array();
    }

    /**
     * Do a SELECT * FROM $table WHERE $column = '$value'
     * @param $table
     * @param string $whereColumn
     * @param mixed $whereColumnValue
     * @param bool $first
     * @param string $order
     * @return array
     */
    public function read($table, $whereColumn = '', $whereColumnValue = null, $first = false, $order = ''){
        if($whereColumn && $whereColumnValue !== null){
            return $this->db->query("SELECT *
								FROM $table
								WHERE $whereColumn = ?
								" . $order . ($first ? " LIMIT 1" : ''), $whereColumnValue);
        } else {
            return $this->db->query("SELECT * FROM $table");
        }
    }

    /**
     * @param $table
     * @param string $whereColumn1
     * @param null $whereColumnValue1
     * @param string $whereColumn2
     * @param null $whereColumnValue2
     * @return array
     */
    public function readTwoKeys($table, $whereColumn1 = '', $whereColumnValue1 = null, $whereColumn2 = '', $whereColumnValue2 = null){
        if($whereColumn1 && $whereColumnValue1 !== null && $whereColumn2 && $whereColumnValue2 !== null){
            $values = array($whereColumnValue1, $whereColumnValue2);
            return $this->db->query("SELECT *
								FROM $table
								WHERE $whereColumn1 = ? AND $whereColumn2 = ? 
								LIMIT 1", $values);
        } else {
            return $this->db->query("SELECT * FROM $table");
        }
    }
    

    /**
     * Do an INSERT query
     *
     * @param $table
     * @param array $values
     * @param array $valuesUnescaped
     * @return bool|int|string
     */
    public function insert($table, $values = array(), $valuesUnescaped = array()){
        $columns = array();
        $columnsKeys = array();
        $columnsUnescaped = array();

        foreach($values as $c => $val){
            $columns[] = "`$c`";
            $columnsKeys[":$c"] = $val;
        }
        foreach($valuesUnescaped as $c => $val){
            $columns[] = "`$c`";
            $columnsKeys[] = $val;
        }

        if(empty($columns)){
            return false;
        }

        $vals = array_merge(array_keys($columnsKeys), $columnsUnescaped);
        $sql = "INSERT INTO `$table` (" . implode(', ', $columns) . ")
				VALUES (" . implode(', ', $vals) . ")";

        return $this->db->executeWithBinaryFiles($sql, $columnsKeys);
    }

    /**
     * Do an UPDATE query
     *
     * @param $table
     * @param $column
     * @param $columnValue
     * @param array $values
     * @param array $valuesUnescaped
     * @return bool|int|string
     */
    public function update($table, $column, $columnValue, $values = array(), $valuesUnescaped = array()){
        $set = array();
        $valuesToEscape = array();

        foreach($values as $c => $val){
            $set[] = "`$c` = ?";
            $valuesToEscape[] = $val;
        }

        foreach($valuesUnescaped as $c => $val){
            $set[] = "`$c` = $val";
        }

        if(empty($set)){
            return false;
        }

        $sql = "UPDATE `$table` SET " . implode(', ', $set) . " WHERE `$column` = ?";
        $valuesToEscape[] = $columnValue;

        return $this->db->exec($sql, $valuesToEscape);
    }

    /**
     * Do an DELETE query
     *
     * @param $table
     * @param $column
     * @param $columnValue
     * @return bool|int|string
     */
    public function delete($table, $column, $columnValue){
        $valuesToEscape = array();

        $sql = "DELETE FROM `$table` WHERE `$column` = ?";
        $valuesToEscape[] = $columnValue;

        return $this->db->exec($sql, $valuesToEscape);
    }


    /**
     * @param $table
     * @param $column1
     * @param $column2
     * @param $columnValue1
     * @param $columnValue2
     * @return bool|int
     */
    public function deleteTwoKeys($table, $column1, $column2, $columnValue1, $columnValue2){
        $valuesToEscape = array();

        $sql = "DELETE FROM `$table` WHERE `$column1` = ? AND `$column2` = ?";
        $valuesToEscape[] = $columnValue1;
        $valuesToEscape[] = $columnValue2;

        return $this->db->exec($sql, $valuesToEscape);
    }

    /**
     * Do an DELETE query WHERE column IN
     *
     * @param $table
     * @param $column
     * @param $columnValues
     * @return bool|int|string
     */
    public function deleteIn($table, $column, $columnValues){

        if(!count($columnValues)){
            return false;
        }

        $sql = "DELETE FROM `$table` WHERE `$column` IN (" . implode(',', $columnValues) . ")";

        return $this->db->exec($sql);

    }

    /**
     * SHOW COLUMNS FROM $table
     *
     * @param $table
     * @return array
     */
    public function showColumns($table)
    {
        return $this->db->query("SHOW COLUMNS FROM `$table`");
    }

    /**
     * @return Database
     */
    public function getDb()
    {
        return $this->db;
    }
    /**
     * @param Database $db
     */
    public function setDb($db)
    {
        $this->db = $db;
    }
    
}