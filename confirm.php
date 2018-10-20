<?php
$user_id = $_GET['id'];
$token = $_GET['token'];
require 'cnxDB.php';
$req = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$req->execute([$user_id]);
$user = $req->fetch(PDO::FETCH_ASSOC);
session_start();

if($user && $user['confirmation_token'] === $token ){
    $pdo->prepare('UPDATE users SET confirmation_token = NULL, confirmed_at = NOW() WHERE id = ?')->execute([$user_id]);
    $_SESSION['flash']['success'] = 'Compte crée avec success';
    $_SESSION['auth'] = $user;
    header('Location: account.php');
}else{
    $_SESSION['flash']['danger'] = "Token non valide";
    header('Location: login.php');
}
