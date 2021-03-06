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

    /* override */
    public static function add_item ( array $params ) {
        $params['name'] = self::_filter_input($params['name']);
        $params['passwd'] = self::passwd_hash($params['passwd']);
        return parent::add_item($params);
    }

    /* override */
    public static function update_item_by_id($id, $column, $value) {
        if ($column === 'passwd') {
            $value = self::passwd_hash($value);
        }
        return parent::update_item_by_id($id, $column, $value);
    }

    public static function confirm_registration($id, $token) {
        $sql = "UPDATE `User` SET confirmed = 1 WHERE id = ? AND token = ?";
        return Database::execute($sql, array($id, $token));
    }

    public static function update_token($id, $token) {
        $sql = "UPDATE `User` SET token = ? WHERE id = ?";
        return Database::execute($sql, array($token, $id));
    }

    public static function passwd_hash($passwd) {
        return password_hash($passwd, PASSWORD_DEFAULT);
    }

    public static function passwd_verify($passwd, $hashed) {
        return password_verify($passwd, $hashed);
    }

    public static function init_token() {
        /* php 7 only */
        return bin2hex(random_bytes((self::TOKEN_SIZE / 2)));
    }
}

?>
