<?php
//if (isset($_POST['btnforget'])) {
    if (!empty($_POST) && !empty($_POST['email'])) {
        require_once 'cnxDB.php';
        require_once 'function.php';
        $req = "SELECT * FROM users WHERE email = ? AND confirmed_at IS NOT NULL";
        $reponse = $pdo->prepare($req);
        $reponse->execute([$_POST['email']]);
        $user = $reponse->fetch();
        if ($user) {
            session_start();
            $reset_token = str_random(50);
            $req2 = "UPDATE users SET reset_token=?,reset_at= Now() WHERE id=?";
            $reponse2 = $pdo->prepare($req2);

            $reponse2->execute([$reset_token, $user->id]);
            $_SESSION['flash']['success'] = "your password has been sent by email";
            $destinataire=$_POST['email'];
            $sujet= 'reinitialisation de mot de passe ';
            $message= "A fin de réinitialiser votre mot de passe merci de cliquer sur ce lien\n\n<a href='http://localhost:63342/EspaceMembre/reset.php?id={$user->id}&token=$reset_token'>réinitialiser votre mot de passe</a>";
            $headers = "From: \"expediteur moi\"<asmatest0@gmail.com>\n";
            $headers .= "Reply-To: asmatest0@gmail.com\n";
            $headers .= "Content-Type: text/plain; charset=\"iso-8859-1\"";
            ini_set('SMTP', 'localhost');
            ini_set('smtp_port', '1025');
            if(mail($destinataire,$sujet,$message,$headers))
            {
                echo "L'email a bien été envoyé.";
            }
            else
            {
                echo "Une erreur c'est produite lors de l'envois de l'email.";
            }
            header('Location: changepassword.php');

            exit();        }
            else {
            $_SESSION['flash']['danger'] = "no account corresponds to this email";
        }
    }
//}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css"
          integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <link rel="stylesheet" href="css/s'inscrire.css">
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
<br>
<br>
<div class="container">
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
    <div class="row">
        <div class="col-md-5 well">
            <img src="css/forgot.jpeg" class="card-img" alt="" width=450 height="500">
        </div>
        <div class="col-md-2"></div>
        <div class="col-md-5 well">

            <h4 style="color: whitesmoke">Password Renitialisation </h4>
            <hr>
            <form action="" method="post">
                <div class="form-group">
                    <i class="fa fa-envelope prefix white-text"></i>
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Email Address"/>
                </div>
                <div class="form-group">
                    <input type="submit" name="btnforget" class="btn btn-success" value="Envoyer"/>
                </div>
            </form>
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
