<?php
/*
** This class wrap all request about picture table.
*/

require_once dirname(__FILE__) . '/Ressource.class.php';
require_once dirname(__FILE__) . '/Like.class.php';
require_once dirname(__FILE__) . '/Comment.class.php';

final class Picture extends Ressource {
    protected static $_table_name = 'Picture';
    protected static $_columns = array(
        'id' => '',
        'user_id' => '',
        'url_id' => '',
        'path' => '',
        'title' => '',
        'md5' => '',
        'creation' => ''
    );

    /* override */
    public static function add_item ( array $params ) {
        $params['title'] = self::_filter_input($params['title']);
        return parent::add_item($params);
    }

    // public static function delete_image_file( $path ) {
    //     return unlink($path);
    // }

    public static function delete_picture_by_id( $id ) {
        if (isset($id)) {
            Like::del_item_by(array('picture_id' => $id));
            Comment::del_item_by(array('picture_id' => $id));
            return parent::del_item_by(array('id' => $id));
        }
        return false;
    }

    public static function get_most_liked ( $limit = -1, $offset = 0 ) {
        $sql = "SELECT picture.*, COUNT(like.id) FROM like INNER JOIN picture ON picture.id = like.picture_id GROUP BY picture_id ORDER BY COUNT(like.id) DESC LIMIT :limit OFFSET :offset";
        return Database::fetch($sql, array('limit' => $limit, 'offset' => $offset));
    }

    public static function get_most_commented ( $limit = -1, $offset = 0 ) {
        $sql = "SELECT picture.*, COUNT(comment.id) FROM comment INNER JOIN picture ON picture.id = comment.picture_id GROUP BY picture_id ORDER BY COUNT(comment.id) DESC LIMIT :limit OFFSET :offset";
        return Database::fetch($sql, array('limit' => $limit, 'offset' => $offset));
    }

    // public static function get_last_week ( $limit = -1, $offset = 0 ) {
    //     $sql = "SELECT * FROM picture WHERE creation > date('now', '-7 day') ORDER BY creation DESC LIMIT $limit OFFSET $offset";
    //     return Database::fetch($sql);
    // }
}

?>
