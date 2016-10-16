<?php
/*
** This class wrap PDO instance as singleton
*/

include_once dirname(__FILE__) . '/../config/database.php';

final class Database {
    /* singleton */
    private static $_pdo_st = NULL;

    private static function _init_pdo() {
        $persistent = array(PDO::ATTR_PERSISTENT => TRUE);
        try {
          self::$_pdo_st = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, $persistent);
          self::$_pdo_st->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          self::$_pdo_st->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        }
        catch (PDOException $e) {
          echo 'Connexion échouée : ' . $e->getMessage();
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

    public static function insert($sql, $params) {
        self::_connect();
        $stmt = self::$_pdo_st->prepare($sql);
        return ($stmt->execute($params));
    }
}

/* Création d'un objet PDOStatement */
// $stmt = $dbh->prepare('SELECT foo FROM bar');

/* Création d'un second objet PDOStatement */
// $otherStmt = $dbh->prepare('SELECT foobaz FROM foobar');

/* Exécute la première requête */
// $stmt->execute();

/* Récupération de la première ligne uniquement depuis le résultat */
// $stmt->fetch();

/* L'appel suivant à closeCursor() peut être requis par quelques drivers */
// $stmt->closeCursor();

/* Maintenant, nous pouvons exécuter la deuxième requête */
// $otherStmt->execute();

?>
