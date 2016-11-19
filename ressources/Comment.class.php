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

    public static function add_item ( array $params ) {
        if (parent::add_item($params)) {
            return Picture::increment($params['picture_id'], 'comments');
        }
        return false;
    }

    public static function del_item_by_id ( $id ) {
        $comment = self::get_item_by('id', $id);
        if (parent::del_item_by_id($id)) {
            return Picture::decrement($comment['picture_id'], 'comments');
        }
        return false;
    }
}

?>
