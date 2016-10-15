<?php
/*
** This class wrap PDO instance as singleton
*/

include_once dirname(__FILE__) . '/../config/database.php';

final class Database {
    /* singleton */
    private static $_pdo_st = null;

    private static function _init_pdo() {
        try {
          self::$_pdo_st = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
          self::$_pdo_st->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          self::$_pdo_st->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        }
        catch (PDOException $e) {
          echo 'Connexion échouée : ' . $e->getMessage();
        }
    }

    private function __construct() {
    }

    public static function connect() {
        if (is_null(self::$_pdo_st)) {
            self::_init_pdo();
        }
        return (self::$_pdo_st);
    }

    public static function prepare($sql) {
      self::$_pdo_st->prepare($sql);
    }
}

?>
