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

        $sql = array();
        $sql[] = "SELECT * FROM `$table` WHERE";
        foreach ($params as $key => $val) {
            $sql[] = "`$key` = :$key";
        }
        $sql[0] = $sql[0] . $sql[1];
        $sql = implode($sql, ' AND ');

        return Database::fetch_one($sql, $paramified);
    }

    public static function get_all_items_by ( array $params ) {
        $table = static::$_table_name;
        $paramified = self::_paramify($params);

        $sql = array();
        $sql[] = "SELECT * FROM `$table` WHERE";
        foreach ($params as $key => $val) {
            $sql[] = "`$key` = :$key";
        }
        $sql[0] = $sql[0] . $sql[1];
        $sql = implode($sql, ' AND ');

        return Database::fetch($sql, $paramified);
    }

    public static function update_item_by_id($id, $column, $value) {
        $table = static::$_table_name;
        if (array_key_exists($column, static::$_columns) === TRUE) {
            $sql = "UPDATE `$table` SET $column = ? WHERE id = ?";
            echo $sql;
            return Database::execute($sql, array($value, $id));
        }
        return false;
    }

    public static function del_item_by_id ( $id ) {
        $table = static::$_table_name;
        $sql = "DELETE FROM `$table` WHERE `id` = ?";
        return Database::execute($sql, array($id));
    }

    public static function fetch_all( $order = 'DESC', $limit = -1 ) {
        $table = static::$_table_name;
        $sql = "SELECT * FROM `$table` ORDER BY `id` $order LIMIT $limit";
        return Database::fetch($sql);
    }
}

?>
