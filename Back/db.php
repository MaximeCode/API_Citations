<?php

const MYSQL_HOST = '192.168.56.4';
const MYSQL_PORT = 3306;
const MYSQL_NAME = 'Citations';
const MYSQL_USER = 'gitea';
const MYSQL_PASSWORD = 'password';

try {
    $pdo = new PDO(
        sprintf('mysql:host=%s;dbname=%s;port=%s;charset=utf8', MYSQL_HOST, MYSQL_NAME, MYSQL_PORT),
        MYSQL_USER,
        MYSQL_PASSWORD
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $exception) {
    die('Erreur lors de la connexion : ' . $exception->getMessage());
}
