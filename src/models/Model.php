<?php

class Model {
    protected static $tableName = '';
    protected static $columns = [];
    protected $values = [];

    function __construct($arr, $sanitaze = true) {
        $this->loadFromArray($arr, $sanitaze);
    }

    public function loadFromArray($arr, $sanitaze = true) {
        if($arr) {
            $conn = Database::getConnection();
            foreach($arr as $key => $value) {
                $cleanValue = $value;
                if($sanitaze && isset($cleanValue)) {
                    $cleanValue = strip_tags(trim($cleanValue));
                    // $cleanValue = htmlentities($cleanValue, ENT_NOQUOTES);
                    $cleanValue = mysqli_real_escape_string($conn, $cleanValue);
                }
                $this->$key = $cleanValue;
            }
            $conn->close();
        }
    }

    public function __get($key) {
        return $this->values[$key];
    }

    public function __set($key, $value) {
        $this->values[$key] = $value;
    }

    public function getValues() {
        return $this->values;
    }

    public static function get($params = [], $columns = '*') {
        $object = [];
        $class = get_called_class();

        $result = static::getResultFromSelect($params, $columns);

        while($row = $result->fetch_assoc()) {
            $object[] = new $class($row);
        }

        return $object;
    }
    
    public static function getOne($params = [], $columns = '*') {
        $class = get_called_class();

        $result = static::getResultFromSelect($params, $columns);

        return $result ? new $class($result->fetch_assoc()) : null;
    }

    public static function getResultFromSelect($params = [], $columns = '*') {
        $sql = "SELECT ${columns} FROM "
        . static::$tableName
        . static::getFilters($params);

        $result = Database::getResultFromQuery($sql);
        return $result;
    }

    public static function getCount($filters = []) {
        $result = static::getResultFromSelect($filters, 'count(*) as count');
        return $result->fetch_assoc()['count'];
    }

    public static function getAbsentUsers() {
        $today = date('Y-m-d');

        $sql = "SELECT name FROM users WHERE end_date IS NULL
        AND deleted_at IS NULL
        AND id NOT IN (SELECT user_id FROM working_hours
        WHERE work_date = '{$today}' AND time1 IS NOT NULL)";

        $result = Database::getResultFromQuery($sql);

        $absentUsers = [];
        if($result->num_rows) {
            while($row = $result->fetch_assoc()) {
                array_push($absentUsers, $row['name']);
            }
        }

        return $absentUsers;
    }

    public function insert() {
        $sql = "INSERT INTO " . static::$tableName . " ("
        . implode(',', static::$columns) . ") VALUES (";

        foreach(static::$columns as $col) {
            $sql .= static::getFormatedValue($this->$col) . ",";
        } 

        $sql[strlen($sql) - 1] = ')';

        $id = Database::executeSql($sql);
        $this->id = $id;
    }

    public function update() {
        $sql = "UPDATE " . static::$tableName . " SET ";
        foreach(static::$columns as $col) {
            $sql .= " ${col} = " . static::getFormatedValue($this->$col) . ",";
        }

        $sql[strlen($sql) - 1] = ' ';
        $sql .= "WHERE id = {$this->id}";
        Database::executeSql($sql);
    }

    public static function deleteById($id) {
        $date = date('Y-m-d');
        $sql = "UPDATE " . static::$tableName . " SET deleted_at = '{$date}'
        WHERE id = $id";
        Database::executeSql($sql);
        // return $sql;
    }

    private static function getFilters($params) {
        $sql = "";

        if(is_array($params) && count($params) > 0) {
            $sql .= " WHERE 1 = 1";
            foreach($params as $column => $value) {
                if($column === 'raw') {
                    $sql .= " AND $value";
                } else {
                    $sql .= " AND $column = "
                    . static::getFormatedValue($value);
                }
            }
        }

        return $sql;
    }

    private static function getFormatedValue($value) {
        if(is_null($value)) {
            return "null";
        } elseif(is_string($value)) {
            return "'$value'";
        } else {
            return $value;
        }
    }
}