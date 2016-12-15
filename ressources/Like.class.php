<?php
/*
** This class wrap all request about like table.
*/

require_once dirname(__FILE__) . '/Ressource.class.php';

final class Like extends Ressource {
    static protected $_table_name = 'Like';
    static protected $_columns = array(
        'id' => '',
        'user_id' => '',
        'picture_id' => ''
    );

    /* override: returns count of all picture commented */
    public static function get_row_count() {
        $table = static::$_table_name;
        $sql = "SELECT COUNT(*) FROM `$table` GROUP BY $table.picture_id";
        return count(Database::fetch($sql, null));
    }
}

?>
