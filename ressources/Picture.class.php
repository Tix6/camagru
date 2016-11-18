<?php
/*
** This class wrap all request about picture table.
*/

require_once dirname(__FILE__) . '/Ressource.class.php';

final class Picture extends Ressource {
    protected $_table_name = 'Picture';
    protected $_columns = array(
        'user_id',
        'path',
        'title'
    );

    public static function del_item_by_id ( $id ) {
        $ressource = self::get_item_by('id', $id);
        if (parent::del_item_by_id( $id ) && isset($ressource)) {
            return unlink($ressource['path']);
        }
        return false;
    }
}

?>
