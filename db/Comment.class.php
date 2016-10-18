<?php
/*
** This class wrap all request about comment table.
*/

require_once dirname(__FILE__) . '/Ressource.class.php';

final class Comment extends Ressource {
    protected $_table_name = 'Comment';
    protected $_columns = array('id', 'user_id', 'user_name', 'picture_id', 'comment');
}

?>
