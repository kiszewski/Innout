<?php

class Model {
    protected static $tableName = '';
    protected static $columns = [];
    protected $values = [];

    function __construct($arr) {
        $this->loadFromArray($arr);
    }

    public function loadFromArray($arr) {
        if($arr) {
            foreach($arr as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    public function __get($key) {
        return $this->values[$key];
    }

    public function __set($key, $value) {
        $this->values[$key] = $value;
    }

    public static function getSelect($columns = '*', $params = []) {
        $sql = "SELECT $columns FROM "
        . static::$tableName
        . static::getFilters($params);
        return $sql;
    }

    private static function getFilters($params) {
        $sql = "";

        if(is_array($params) && count($params) > 0) {
            $sql .= " WHERE 1 = 1";
            foreach($params as $column => $value) {
                $sql .= " AND $column = "
                . static::getFormatedValue($value);
            }
        }

        return $sql;
    }

    private static function getFormatedValue($value) {
        if(is_null($value)) {
            return "null";
        } elseif(is_string($value)) {
            $param = "'$value'";
            return $param;
        } else {
            return $value;
        }
    }
}