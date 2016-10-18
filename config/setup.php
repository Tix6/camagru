<?php
require_once dirname(__FILE__) . '/database.php';
require_once dirname(__FILE__) . '/../sql/create.php';

echo '------ Database setup BEGIN ------' . PHP_EOL;

/* --------------------------- CREATE DATABASE -------------------------------*/

/* Sqlite database is created on pdo instantiation */

try {
    $pdo = new PDO($DB_DSN);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    die('Connexion échouée : ' . $e->getMessage());
}

/* -------------------------------------------------------------------------- */


/* ---------------------------- CREATE TABLES --------------------------------*/

foreach ($TABLES as $table => $sql) {
    echo "create $table table : ";
    $count = $pdo->exec($sql);
    echo "$count rows affected." . PHP_EOL;
}

/* -------------------------------------------------------------------------- */

echo '------- Database setup END -------' . PHP_EOL;
/* close connection */
$pdo = NULL;

?>
