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

    public static function _filter_input($input) {
        return htmlentities(trim($input), ENT_QUOTES);
    }

    private static function _columns_to_str ( array $params ) {
        return implode(array_keys($params), ', ');
    }

    /* add ':' before key names for pdo to bind params */
    private static function _paramify ( array $params ) {
        $paramified = array();
        foreach ($params as $key => $val) {
            $paramified[":$key"] = $val;
        }
        return $paramified;
    }

    private static function _bind_params ( $sql_base, array $params ) {
        $sql_params = array();
        foreach ($params as $key => $val) {
            $sql_params[] = "`$key` = :$key";
        }
        $sql_params = implode($sql_params, ' AND ');
        return ($sql_base . $sql_params);
    }

    public static function get_row_count() {
        $table = static::$_table_name;
        $sql = "SELECT COUNT(id) FROM `$table`";
        return (Database::fetch_one($sql, null))['COUNT(id)'];
    }

    public static function get_row_count_by( array $params ) {
        $table = static::$_table_name;
        $sql = "SELECT COUNT(id) FROM `$table` WHERE ";
        $sql = self::_bind_params($sql, $params);
        return (Database::fetch_one($sql, $params))['COUNT(id)'];
    }

    public static function add_item ( array $params ) {
        $table = static::$_table_name;
        $columns = self::_columns_to_str($params);
        $params_to_bind = implode(array_keys(self::_paramify($params)), ', ');
        $sql = "INSERT INTO `$table` ($columns) VALUES ($params_to_bind)";
        return Database::insert($sql, $params);
    }

    public static function get_item_by ( array $params ) {
        $table = static::$_table_name;
        $paramified = self::_paramify($params);
        $sql_base = "SELECT * FROM `$table` WHERE ";
        $sql = self::_bind_params($sql_base, $params);
        return Database::fetch_one($sql, $paramified);
    }

    public static function get_all_items_by ( array $params, $order = 'ASC', $limit = -1, $offset = 0 ) {
        $table = static::$_table_name;
        $paramified = self::_paramify($params);
        $sql_base = "SELECT * FROM `$table` WHERE ";
        $sql = self::_bind_params($sql_base, $params);
        $sql = $sql . " ORDER BY `id` $order LIMIT $limit OFFSET $offset";
        return Database::fetch($sql, $paramified);
    }

    public static function fetch_all ( $order = 'DESC', $limit = -1, $offset = 0 ) {
        $table = static::$_table_name;
        $sql = "SELECT * FROM `$table` ORDER BY `id` $order LIMIT $limit OFFSET $offset";
        return Database::fetch($sql);
    }

    public static function del_item_by ( array $params ) {
        $table = static::$_table_name;
        $paramified = self::_paramify($params);
        $sql_base = "DELETE FROM `$table` WHERE ";
        $sql = self::_bind_params($sql_base, $params);
        return Database::execute($sql, $paramified);
    }

    public static function update_item_by_id ( $id, $column, $value ) {
        $table = static::$_table_name;
        if (array_key_exists($column, static::$_columns) === TRUE) {
            $sql = "UPDATE `$table` SET $column = ? WHERE id = ?";
            return Database::execute($sql, array($value, $id));
        }
        return false;
    }

}

?>
