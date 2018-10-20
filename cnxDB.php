<?php
/**
 * Created by PhpStorm.
 * User: Imen
 * Date: 19/08/2018
 * Time: 00:06
 */
$pdo = new PDO("mysql:host=localhost;dbname=espace_membre", 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
