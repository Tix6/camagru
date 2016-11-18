<?php

// $CREATE_DB = "CREATE DATABASE IF NOT EXISTS `db_camagru` CHARACTER SET utf8 COLLATE utf8_general_ci;";

$TABLES = array(
    /* USER TABLE */
    'user' => "CREATE TABLE IF NOT EXISTS `User` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `name` varchar(255) NOT NULL,
    `passwd` varchar(255) NOT NULL,
    `mail` varchar(255) NOT NULL,
    `token` varchar(255) DEFAULT NULL,
    `confirmed` tinyint DEFAULT 0,
    `level` tinyint DEFAULT 0,
    UNIQUE (`mail`)
    );",

    /* PICTURE TABLE */
    'picture' => "CREATE TABLE IF NOT EXISTS `Picture` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `user_id` int NOT NULL,
    `title` varchar(255) NOT NULL,
    `path` varchar(255) NOT NULL,
    `likes` int DEFAULT 0,
    `creation` timestamp DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(user_id) REFERENCES user(id)
    UNIQUE (`path`)
    );",

    /* STICKER TABLE */
    'sticker' => "CREATE TABLE IF NOT EXISTS `Sticker` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `title` varchar(255) NOT NULL,
    `path` varchar(255) NOT NULL,
    UNIQUE (`path`)
    );",

    /* COMMENT TABLE */
    'comment' => "CREATE TABLE IF NOT EXISTS `Comment` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `user_id` int NOT NULL,
    `user_name` varchar(255) NOT NULL,
    `picture_id` int NOT NULL,
    `comment` text NOT NULL,
    FOREIGN KEY (`user_id`) REFERENCES User(id),
    FOREIGN KEY (`picture_id`) REFERENCES Picture(id)
    );",

    /* LIKE TABLE */
    'like' => "CREATE TABLE IF NOT EXISTS `Like` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
    `user_id` int NOT NULL,
    `picture_id` int NOT NULL,
    FOREIGN KEY (`user_id`) REFERENCES User(id),
    FOREIGN KEY (`picture_id`) REFERENCES Picture(id)
    );"
);

?>
