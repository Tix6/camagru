<?php
/*
** This class wrap PDO instance as singleton
** Constants in this class should be in a separate file.
*/

final class Database {
  /* config */
  private static $_DSN = 'mysql:dbname=db_camagru;host=127.0.0.1;port=3307';
  private static $_USER = 'root';
  private static $_PW = 'root';
  /* singleton */
  private static $_pdo_st = null;

  private static function _init_pdo() {
    try {
      self::$_pdo_st = new PDO(self::$_DSN, self::$_USER, self::$_PW);
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
