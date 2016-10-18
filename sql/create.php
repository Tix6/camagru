<?php

// $CREATE_DB = "CREATE DATABASE IF NOT EXISTS `db_camagru` CHARACTER SET utf8 COLLATE utf8_general_ci;";

$TABLES = array(
    /* USER TABLE */
    'user' => "CREATE TABLE IF NOT EXISTS `User` (
    `id` int NOT NULL,
    `name` varchar(255) NOT NULL,
    `passwd` varchar(255) NOT NULL,
    `mail` varchar(255) NOT NULL,
    `token` varchar(255) DEFAULT NULL,
    `level` tinyint DEFAULT 0,
    PRIMARY KEY (`id`),
    UNIQUE (`mail`)
    );",

    /* PICTURE TABLE */
    'picture' => "CREATE TABLE IF NOT EXISTS `Picture` (
    `id` int NOT NULL,
    `user_id` int NOT NULL,
    `path` varchar(255) NOT NULL,
    `likes` int DEFAULT 0,
    `creation` timestamp DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES User(id),
    UNIQUE (`path`)
    );",

    /* COMMENT TABLE */
    'comment' => "CREATE TABLE IF NOT EXISTS `Comment` (
    `id` int NOT NULL,
    `user_id` int NOT NULL,
    `user_name` varchar(255) NOT NULL,
    `picture_id` int NOT NULL,
    `comment` text NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES User(id),
    FOREIGN KEY (`picture_id`) REFERENCES Picture(id)
    );",

    /* LIKE TABLE */
    'like' => "CREATE TABLE IF NOT EXISTS `Like` (
    `id` int NOT NULL,
    `user_id` int NOT NULL,
    `picture_id` int NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES User(id),
    FOREIGN KEY (`picture_id`) REFERENCES Picture(id)
    );"
);

?>
