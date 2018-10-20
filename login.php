<?php
require_once 'function.php';

if(isset($_POST['btnLogin'])) {
    if (!empty($_POST) && !empty($_POST['email']) && !empty($_POST['password'])) {
        require_once 'cnxDB.php';
        $req = "SELECT * FROM users WHERE email = :email   AND confirmed_at IS NOT NULL";
        $reponse = $pdo->prepare($req);
        $password_hash = password_hash($_POST['password'],1 );
        $reponse->execute(array('email' => $_POST['email']));
        $user = $reponse->fetch(PDO::FETCH_ASSOC);


        if ($_POST['password'] == $user['mdp']) {
            echo "verif";

            session_start();
            $_SESSION['auth'] = $user;
            $_SESSION['flash']['success'] = "Vous étes maintenant connecté";


        if ($_POST['remember']) {
            $remember_token = str_random(250);
            $req2 = "UPDATE users SET remember_token =? WHERE id=?";
            $reponse2 = $pdo->prepare($req2);
            $reponse2->execute([$remember_token, $user->id]);
            setcookie('remember', $user->id . '==' . $remember_token . sha1($user->id), time() + 60 * 60 * 24 * 7);
        }

            header('Location: account.php');
            exit();
        } else {
            $_SESSION['flash']['danger'] = "email ou mot de passe incorrect";
        }
    }
}

if (isset($_COOKIE['remember']) && !isset($_SESSION['auth'])) {
    require 'cnxDB.php';
    if (!isset($pdo)) {
        global $pdo;
    }
    $remember_token = $_COOKIE['remember'];
    $parts = explode('==', $remember_token);
    $user_id = $parts[0];
    $req = "SELECT * FROM users WHERE id = ?";
    $reponse = $pdo->prepare($req);
    $reponse->execute([$user_id]);
    $user = $reponse->fetch();
    if ($user) {
        $expected = $user_id . '==' . $user->remember_token . sha1($user_id);
        if ($expected == $remember_token) {
            $_SESSION['auth'] = $user;
            setcookie('remember', $remember_token, time() + 60 * 60 * 24 * 7);

        } else {
            setcookie('remember', NULL, -1);

        }
    } else {
        setcookie('remember', NULL, -1);
    }
}
if (isset($_SESSION['auth'])) {
    header('Location: account.php');
    exit();

}


?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css"
          integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <link rel="stylesheet" href="css/seconnecter.css">
</head>
<body>
<nav class="navbar navbar-expand-md bg-dark navbar-dark" >

    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
            <li class="nav-item"><a class="navbar-brand" href="#">ESPACE MEMBRE</a></li>
            <?php if (isset($_SESSION['auth'])): ?>
                <li class="nav-item"><a href="logout.php"><span class="navbar-brand"></span> Logout </a></li>
            <?php else: ?>
                <li class="nav-item"><a href="register.php"><span class="navbar-brand"></span> Sign Up</a></li>
                <li class="nav-item"><a href="login.php"><span class="navbar-brand"></span> Login</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>



<div class="container">

    <div class="flex-column">
        <div class="col-md-6 mb-5">
            From this space, You can send your publications to the platform.
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php if (isset($_SESSION['flash'])): ?>
                    <?php foreach ($_SESSION['flash'] as $type => $message): ?>
                        <div class="alert alert-<?= $type; ?>">
                            <?= $message; ?>
                        </div>
                    <?php endforeach; ?>
                    <?php unset($_SESSION['flash']); ?>
                <?php endif; ?>

            </div>
        </div>
        <div class="col-md-2"></div>
        <div class="col-md-5 ">
            <div class="card indigo form-pink" style="background:palevioletred; opacity: 0.9;">
                <div class="card-body">
                    <h3 class="text-center white-text py-3"><i class="fa fa-user"></i> Connectez Vous:</h3>
            <form action="login.php" method="post">
                <div class="form-group">
                    <i class="fa fa-envelope prefix white-text"></i>
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Email Address"/>
                </div>
                <div class="form-group">

                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Password"/>
                </div>
                <div class="form-group">
                    <label><input type="checkbox" name="remember" value="1">Remember me</label>
                    <h6><a href="forget.php">Forgot your Password? </a></h6>
                </div>
                <div class="form-group">
                    <input type="submit" name="btnLogin" class="btn btn-primary" value="Login"/>
                </div>
                <h6>Do not have an account? <a href="register.php">in Sign up</a></h6>

            </form>

        </div>
            </div>
        </div>
    </div>
</div>
<footer class="portfolio-footer">
    You can find us on :
    <a href=""> <i class="fab fa-facebook-square" style="color :rgb(10, 140, 253)"> </i></a>
    <a href=""> <i class="fab fa-github" style="color :rgb(78, 163, 21)"> </i></a>
    <a href=""> <i class="fab fa-instagram" style="color :rgb(133, 7, 18)"></i> </a>
    <a href=""> <i class="fab fa-linkedin-in" style="color :rgb(66, 13, 211)"></i> </a>
</footer>

</body>
</html>
