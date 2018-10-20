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
<div class="collapse navbar-collapse" id="collapsible Navbar">
    <ul class="navbar-nav">
        <li class="nav-item"><a class="navbar-brand" href="#">ESPACE MEMBRE</a></li>
        <ul class="nav navbar-nav navbar-right">
            <li class="nav-item"><a href="register.php"><span class="navbar-brand"></span> Sign Up</a></li>
            <li class="nav-item"><a href="login.php"><span class="navbar-brand"></span> Login</a></li>
        </ul>
    </ul>
</div>
</nav>
<!--______________________________________________________________________________________________-->
<?php
require_once 'function.php';
session_start();
if (!empty($_POST)) {
    $errors = array();
    require_once 'cnxDB.php';

    if (empty($_POST['first_name']) || preg_match('/^[azA-Z0-9_]+$/', $_POST['first_name'])) {
        $errors['first_name'] = "Entrer votre nom";
    } else {
        $req = "SELECT id FROM users WHERE first_name = ? ";
        $reponse = $pdo->prepare($req);
        $reponse->execute([$_POST['first_name']]);
        $user = $reponse->fetch();
        if ($user) {
            $errors['first_name'] = "C nom est deja utilisé";
        }
    }

    if (empty($_POST['last_name']) || preg_match('/^[az0-9_]+$/', $_POST['last_name'])) {
        $errors['last_name'] = "Entrer votre prenom";
    } else {
        $req = "SELECT id FROM users WHERE last_name = ? ";
        $reponse = $pdo->prepare($req);
        $reponse->execute([$_POST['last_name']]);
        $user = $reponse->fetch();
        if ($user) {
            $errors['last_name'] = 'C prenom est deja utilisé';
        }
    }
    if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Entrer votre email";
    } else {
        $req = "SELECT id FROM users WHERE email = ? ";
        $reponse = $pdo->prepare($req);
        $reponse->execute([$_POST['email']]);
        $user = $reponse->fetch();
        if ($user) {
            $errors['email'] = 'C mail est deja utilisé';
        }
    }

    if (empty($_POST['password']) || preg_match_all('$S*(?=S{8,})(?=S*[a-z])(?=S*[A-Z])(?=S*[d])(?=S*[W])S*$', $_POST['password']) || $_POST['password'] != $_POST['pwd']) {
        $errors['password'] = "Entrer un password valid";
    }

    if (empty($errors)) {

        if(isset($_FILES['file_cin']))
        {
            $dossier = 'upload/';
            $info=pathinfo($_FILES['file_cin']['name']);

            $fichier = uniqid().".".$info['extension'];
            // ['tmp_name'] Nom temporaire donné par serveur ou fichier charger

            if(move_uploaded_file($_FILES['file_cin']['tmp_name'], $dossier . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
            {
                echo 'Upload effectué avec succès !'.$fichier;
            }
            else //Sinon (la fonction renvoie FALSE).
            {
                echo 'Echec de l\'upload !';
            }
        }
        $req = "INSERT INTO users(first_name, last_name, email, password,image, mdp,confirmation_token) VALUES (:first_name, :last_name, :email, :password,:image,:mdp,:confirmation_token)";
        $reponse = $pdo->prepare($req);
        $mdp=$_POST['password'];
        $password_hash = password_hash($_POST['password'],1 );
        $token = str_random(50);
        $reponse->bindParam(':first_name', $_POST['first_name']);
        $reponse->bindParam(':last_name', $_POST['last_name']);
        $reponse->bindParam(':email', $_POST['email']);
        $reponse->bindParam(':password', $password_hash);
        $reponse->bindParam(':confirmation_token', $token);
        $reponse->bindParam(':mdp', $mdp);
        $reponse->bindParam(':image', $fichier);

        $reponse->execute();
        ini_set('SMTP', 'localhost');
        ini_set('smtp_port', '1025');
        $user_id = $pdo->LastInsertId();
        $sujet = 'Sujet de l\'email';
        $message = "A fin de valider votre compte merci de cliquer sur ce lien \n\n<a href='http://localhost:63342/EspaceMembre//confirm.php?id=$user_id&token=$token'>Activer votre compte</a>\");";
    
        $destinataire = $_POST['email'];
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
        $_SESSION['flash']['success'] = "la confirmation email has been sent to you to validate your account";
        header('Location:login.php');
        exit();
    }
}
?>
<div class="container">
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-5 well">
            <?php if (!empty($errors)) { ?>
                <div class="alert alert-danger">
                    <p>you have not completed the form correctly</p>
                    <ul>
                        <?php foreach ($errors as $error) { ?>
                            <li><?= $error; ?></li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>

                <?php
            }
            ?>

            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" name="first_name" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control"/>
                </div>
                <!--exercice ajout champ CIN et son UPLOAD-->


                <div class="form-group row">
                    <label class="col-2 col-form-label"></label>
                    <div class="col-10">
                        <input class="form-control-file" type="file" name="file_cin"><br>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="pwd"> Confirm Password</label>
                    <input type="password" id="pwd" name="pwd" class="form-control"/>
                </div>
                <div class="form-group">
                    <input type="submit" name="btnRegister" class="btn btn-primary" value="Register"/>
                </div>
                <div class="form-group">
                    <h6>If you already have an account, <a href="login.php">please log in here</a></h6>
                </div>
            </form>

        </div>
    </div>
</div>

</body>
</html>