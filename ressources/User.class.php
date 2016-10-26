<?php
/*
** This class wrap all request about user table.
*/

require_once dirname(__FILE__) . '/Ressource.class.php';

final class User extends Ressource {
    const TOKEN_SIZE = 64;

    protected static $_table_name = 'User';
    protected static $_columns = array(
        'name' => '',
        'passwd' => '',
        'mail' => '',
        'token' => ''
    );

    public static function add_item ( array $params ) {
        $params[':passwd'] = self::_passwd_hash($params[':passwd']);
        return parent::add_item($params);
    }

    public static function confirm_registration($id, $token) {
        $sql = "UPDATE User SET confirmed = 1 WHERE id = ? AND token = ?";
        return Database::execute($sql, array($id, $token));
    }

    private static function _passwd_hash($passwd) {
        return password_hash($passwd, PASSWORD_DEFAULT);
    }

    private static function _passwd_verify($passwd, $hashed) {
        return password_verify($passwd, $hashed);
    }

    public static function init_token() {
        return bin2hex(random_bytes((self::TOKEN_SIZE / 2)));
    }
}

?>
