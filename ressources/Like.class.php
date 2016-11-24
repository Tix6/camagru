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
}

?>
