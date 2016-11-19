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
        'path' => '',
        'title' => '',
        'md5' => '',
        'likes' => '',
        'creation' => ''
    );

    public static function delete_image_file( $path ) {
        return unlink($path);
    }

    public static function del_item_by_id ( $id ) {
        $ressource = self::get_item_by('id', $id);
        if (parent::del_item_by_id( $id ) && isset($ressource)) {
            return self::delete_image_file($ressource['path']);
        }
        return false;
    }
}

?>
