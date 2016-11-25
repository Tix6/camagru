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

    public static function add_item ( array $params ) {
        if (parent::add_item($params)) {
            return Picture::increment($params['picture_id'], 'likes');
        }
        return false;
    }

    public static function del_item_by_id ( $id ) {
        $like = self::get_item_by(array('id' => $id));
        if (parent::del_item_by_id($id)) {
            return Picture::decrement($like['picture_id'], 'likes');
        }
        return false;
    }

}

?>
