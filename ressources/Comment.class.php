<?php
/*
** This class wrap all request about comment table.
*/

require_once dirname(__FILE__) . '/Ressource.class.php';
require_once dirname(__FILE__) . '/Picture.class.php';

final class Comment extends Ressource {
    protected static $_table_name = 'Comment';
    protected static $_columns = array(
        'id' => '',
        'user_id' => '',
        'picture_id' => '',
        'comment' => ''
    );

    /* override */
    public static function add_item ( array $params ) {
        $params['comment'] = self::_filter_input($params['comment']);
        if (!empty($params['comment'])) {
            return parent::add_item($params);
        }
        return false;
    }

    /* override: returns count of all picture commented */
    public static function get_row_count() {
        $table = static::$_table_name;
        $sql = "SELECT COUNT(*) FROM `$table` GROUP BY $table.picture_id";
        return count(Database::fetch($sql, null));
    }
}

?>
