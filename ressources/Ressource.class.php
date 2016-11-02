<?php
/*
** The purpose of this abstract class is to make sql query templates for the ressources.
*/

require_once dirname(__FILE__) . '/Database.class.php';

abstract class Ressource {
    protected static $_table_name;
    protected static $_columns;

    protected function __construct() {}

    /* returns array with pdo params as key. Useful for pdo to bind params */
    public static function get_fields() {
        foreach (static::$_columns as $key => $val) {
            $fields[":$key"] = '';
        }
        return $fields;
    }

    public static function add_item ( array $params ) {
        if (count($params) != count(static::$_columns))
            return FALSE;
        $table = static::$_table_name;
        $columns_str = implode(array_keys(static::$_columns), ', ');
        $params_str = implode(array_keys($params), ', ');
        $sql = "INSERT INTO `$table` ($columns_str) VALUES ($params_str)";
        // echo $sql . PHP_EOL;
        return Database::insert($sql, $params);
    }

    public static function get_item_by_id ( $id ) {
        $table = static::$_table_name;
        $sql = "SELECT * FROM `$table` WHERE `id` = ?";
        return Database::fetch($sql, array($id));
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
}

?>
