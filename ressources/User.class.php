<?php
/*
** This class wrap all request about user table.
*/

require_once dirname(__FILE__) . '/Ressource.class.php';

final class User extends Ressource {
    protected static $_table_name = 'User';
    protected static $_columns = array(
        'name' => '',
        'passwd' => '',
        'mail' => '',
        'level' => '',
        'token' => ''
    );

    public static function _init_token() {
        return bin2hex(random_bytes(32));
    }
}

?>
