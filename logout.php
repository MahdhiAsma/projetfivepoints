<?php
/**
 * Created by PhpStorm.
 * User: Imen
 * Date: 23/08/2018
 * Time: 16:18
 */
session_start();
setcookie('remember',NULL,-1);
unset($_SESSION['auth']);
$_SESSION['flash']['success'] = 'Vous êtes maintenant déconnecté';
header('Location: login.php');