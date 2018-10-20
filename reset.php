<?php
$user_id = $_GET['id'];
$token = $_GET['token'];
require 'cnxDB.php';
$req = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$req->execute([$user_id]);
$user = $req->fetch(PDO::FETCH_ASSOC);
session_start();
require 'function.php';
//logged();
if (!empty($_POST)) {

    if (empty($_POST['password']) || $_POST['password'] != $_POST['c_password']) {
        $_SESSION['flash']['danger'] = "passwords do not match";
    } else {
        $user_id = $_GET['id'];
        $mdp= $_POST['password'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        require_once 'cnxDB.php';
        $req = $pdo->prepare('UPDATE users SET password=?, mdp=? WHERE id = ?');
        $req->execute([$password , $mdp,$user_id ]);
        $_SESSION['auth'] = $user;

        $_SESSION['flash']['success'] = "your password successfully updated. ";
        header('Location: account.php');
        exit();
    }
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <!--    <link rel="stylesheet" a href="css/bootstrap.min.css">-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar ">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand">Espace Membre</a>
        </div>
        <ul class="nav navbar-nav">
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <?php if (isset($_SESSION['auth'])): ?>
                <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout </a></li>
            <?php else: ?>
                <li><a href="register.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php if (isset($_SESSION['flash'])): ?>
                <?php foreach ($_SESSION['flash'] as $type => $message): ?>
                    <div class="alert alert-<?= $type; ?>">

                    </div>
                <?php endforeach; ?>
                <?php unset($_SESSION['flash']); ?>
            <?php endif; ?>

        </div>
    </div>
    <div class="row">
        <div class="col-md-5 well">
            <img src="go.jpg" class="img-rounded" alt="" width=450 height="500">
        </div>
        <div class="col-md-2"></div>
       <div class="col-md-5 well">
                <h3></h3>
                <form action="" method="post">
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="change your password">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="c_password" placeholder="confirm your password">
                    </div>
                    <button class="btn btn-primary"> change your password</button>
                </form>
            </div>
       </div>
</div>
</body>
</html>