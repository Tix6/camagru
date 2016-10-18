<?php
/*
** This class wrap all request about user table.
*/

require_once dirname(__FILE__) . '/Ressource.class.php';

final class User extends Ressource {
    protected $_table_name = 'User';
    protected $_columns = array('id', 'name', 'passwd', 'mail', 'token', 'level');

    private static function _init_token() {
        ;
    }

    public static function add_item($values) {
        $token = self::_init_token();
        return parent::add_item($values);
    }
}

?>
