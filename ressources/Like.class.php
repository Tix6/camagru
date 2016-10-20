<?php
/*
** This class wrap all request about like table.
*/

require_once dirname(__FILE__) . '/Ressource.class.php';

final class Like extends Ressource {
    protected $_table_name = 'Comment';
    protected $_columns = array('id', 'user_id', 'picture_id');
}

?>
