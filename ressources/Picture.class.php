<?php
/*
** This class wrap all request about picture table.
*/

require_once dirname(__FILE__) . '/Ressource.class.php';

final class Picture extends Ressource {
    protected static $_table_name = 'Picture';
    protected static $_columns = array(
        'id' => '',
        'user_id' => '',
        'url_id' => '',
        'path' => '',
        'title' => '',
        'md5' => '',
        'likes' => '',
        'comments' => '',
        'creation' => ''
    );

    public static function delete_image_file( $path ) {
        return unlink($path);
    }

    public static function del_item_by_id ( $id ) {
        $ressource = self::get_item_by(array('id' => $id));
        if (parent::del_item_by_id( $id ) && isset($ressource)) {
            return self::delete_image_file($ressource['path']);
        }
        return false;
    }

    public static function get_most_liked ( $limit = -1 ) {
        $sql = "SELECT picture.*, COUNT(like.id) FROM like INNER JOIN picture ON picture.id = like.picture_id GROUP BY picture_id ORDER BY COUNT(like.id) DESC LIMIT $limit";
        return Database::fetch($sql);
    }

    public static function get_most_commented ( $limit = -1 ) {
        $sql = "SELECT picture.*, COUNT(comment.id) FROM comment INNER JOIN picture ON picture.id = comment.picture_id GROUP BY picture_id ORDER BY COUNT(comment.id) DESC LIMIT $limit";
        return Database::fetch($sql);
    }

    public static function get_last_week ( $limit = -1 ) {
        $sql = "SELECT * FROM picture WHERE creation > date('now', '-7 day') ORDER BY creation DESC LIMIT $limit";
        return Database::fetch($sql);
    }
}

?>
