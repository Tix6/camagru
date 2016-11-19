<?php
/*
** The purpose of this abstract class is to make sql query templates for the ressources.
*/

require_once dirname(__FILE__) . '/Database.class.php';

abstract class Ressource {
    protected static $_table_name;
    protected static $_columns;

    protected function __construct() {}

    public static function get_fields() {
        return static::$_columns;
    }

    /* add ':' before key names for pdo to bind params */
    private static function _paramify ( array $params ) {
        $paramified_keys = array();
        foreach ($params as $key => $val) {
            $paramified_keys[] = ":$key";
        }
        return $paramified_keys;
    }

    public static function add_item ( array $params ) {
        $table = static::$_table_name;
        $columns = implode(array_keys($params), ', ');
        $params_to_bind = implode((self::_paramify($params)), ', ');
        $sql = "INSERT INTO `$table` ($columns) VALUES ($params_to_bind)";
        // echo $sql . PHP_EOL;
        return Database::insert($sql, $params);
    }

    public static function get_item_by($column, $value) {
        $table = static::$_table_name;
        $sql = "SELECT * FROM `$table` WHERE `$column` = ?";
        return Database::fetch_one($sql, array($value));
    }

    public static function get_all_items_by($column, $value) {
        $table = static::$_table_name;
        $sql = "SELECT * FROM `$table` WHERE `$column` = ?";
        return Database::fetch($sql, array($value));
    }

    public static function update_item_by_id($id, $column, $value) {
        $table = static::$_table_name;
        if (array_key_exists($column, static::$_columns) === TRUE) {
            $sql = "UPDATE `$table` SET $column = ? WHERE id = ?";
            return Database::execute($sql, array($value, $id));
        }
        return false;
    }

    public static function del_item_by_id ( $id ) {
        $table = static::$_table_name;
        $sql = "DELETE FROM `$table` WHERE `id` = ?";
        return Database::execute($sql, array($id));
    }

    public static function fetch_all() {
        $table = static::$_table_name;
        $sql = "SELECT * FROM `$table`";
        return Database::fetch($sql, null);
    }

    public static function increment($id, $column) {
        $table = static::$_table_name;
        if (array_key_exists($column, static::$_columns) === true) {
            $sql = "UPDATE `$table` SET $column = $column + 1 WHERE id = ?";
            return Database::execute($sql, array($id));
        }
        return false;
    }

    public static function decrement($id, $column) {
        $table = static::$_table_name;
        if (array_key_exists($column, static::$_columns) === true) {
            $sql = "UPDATE `$table` SET $column = $column - 1 WHERE id = ?";
            return Database::execute($sql, array($id));
        }
        return false;
    }
}

?>
