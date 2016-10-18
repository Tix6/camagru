<?php
/*
** The purpose of this abstract class is to make sql query templates for the ressources.
*/

require_once dirname(__FILE__) . '/Database.class.php';

abstract class Ressource {
    protected $_table_name;
    protected $_columns;

    protected function __construct() {
    }

    /* returns array as PARAM_NAME => PARAM_VALUE */
    protected static function _paramify ( array $values ) {
        $params = array();
        foreach ($values as $k => $v) {
            $params[$_columns[$k]] = $v;
        }
        return $params;
    }

    public static function add_item ( array $values ) {
        if (count($values) != count($_columns))
            return FALSE;
        $params = self::_paramify($values);
        $columns_str = implode($_columns, ', ');
        $params_str = implode(array_keys($params), ', ');
        $sql = "INSERT INTO `$_table_name` ($columns_str) VALUES ($params_str);";
        return Database::execute($sql, $params);
    }

    public static function get_item_by_id ( $id ) {
        $sql = "SELECT * FROM `$_table_name` WHERE `id` = ? LIMIT 1;";
        return Database::fetch($sql, array($id));
    }

    public static function del_item_by_id ( $id ) {
        $sql = "DELETE FROM `$_table_name` WHERE `id` = ? LIMIT 1;";
        return Database::execute($sql, array($id));
    }

    public static function fetch_all() {
        $sql = "SELECT * FROM $_table_name;";
        return Database::fetch($sql, array());
    }
}

?>
