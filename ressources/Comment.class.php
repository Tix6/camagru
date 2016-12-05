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
}

?>
