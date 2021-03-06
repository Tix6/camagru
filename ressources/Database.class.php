<?php
/*
** This class wrap PDO instance as singleton
*/

final class Database {
    /* singleton */
    private static $_pdo_st = NULL;

    private static function _init_pdo() {
        require_once dirname(__FILE__) . '/../config/database.php';
        try {
          self::$_pdo_st = new PDO($DB_DSN);
          self::$_pdo_st->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          self::$_pdo_st->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
          // activate use of foreign key constraints
          self::$_pdo_st->exec('PRAGMA foreign_keys = ON;');
        }
        catch (PDOException $e) {
          echo 'Connexion à la base de données échouée : ' . $e->getMessage();
        }
    }

    private function __construct() {
    }

    private static function _connect() {
        if (is_null(self::$_pdo_st))
            self::_init_pdo();
    }

    public static function _disconnect() {
        self::$_pdo_st = NULL;
    }

    private static function prepare($sql) {
        self::_connect();
        return self::$_pdo_st->prepare($sql);
    }

    public static function execute($sql, $params) {
        try {
            $stmt = self::prepare($sql);
            $stmt->execute($params);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function insert($sql, $params) {
        try {
            $stmt = self::prepare($sql);
            $stmt->execute($params);
            return self::$_pdo_st->lastInsertId();
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function fetch_one($sql, $params) {
        try {
            $stmt = self::prepare($sql);
            $stmt->execute($params);
            $fetched = $stmt->fetch();
            $stmt->closeCursor();
            return $fetched;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function fetch($sql, $params = null) {
        try {
            $stmt = self::prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return false;
        }
    }
}

?>
