<?php
require_once dirname(__FILE__) . '/database.php';
require_once dirname(__FILE__) . '/../sql/create.php';

echo '------ Database setup BEGIN ------' . PHP_EOL;

/* --------------------------- CREATE DATABASE -------------------------------*/

try {
    $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    die('Connexion échouée : ' . $e->getMessage());
}

/* -------------------------------------------------------------------------- */


/* ---------------------------- CREATE TABLES --------------------------------*/

/* USER */
echo 'create user table : ';
$count = $pdo->exec($CREATE_TABLE_USER);
echo "$count rows affected." . PHP_EOL;

/* PICTURE */
echo 'create picture table : ';
$count = $pdo->exec($CREATE_TABLE_PICTURE);
echo "$count rows affected." . PHP_EOL;

/* COMMENT */
echo 'create comment table : ';
$count = $pdo->exec($CREATE_TABLE_COMMENT);
echo "$count rows affected." . PHP_EOL;

/* LIKE */
echo 'create like table : ';
$count = $pdo->exec($CREATE_TABLE_LIKE);
echo "$count rows affected." . PHP_EOL;

/* -------------------------------------------------------------------------- */

echo '------- Database setup END -------' . PHP_EOL;
/* close connection */
$pdo = NULL;

?>
