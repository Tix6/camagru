<?php
/*
** This class wrap all request about picture table.
*/

require_once dirname(__FILE__) . '/Ressource.class.php';

final class Sticker extends Ressource {
    protected static $_table_name = 'Sticker';
    protected static $_columns = array('path');
}

?>
