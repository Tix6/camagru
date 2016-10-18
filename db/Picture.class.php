<?php
/*
** This class wrap all request about picture table.
*/

require_once dirname(__FILE__) . '/Ressource.class.php';

final class Picture extends Ressource {
    protected $_table_name = 'Picture';
    protected $_columns = array('id', 'user_id', 'path', 'likes', 'creation');
}

?>
