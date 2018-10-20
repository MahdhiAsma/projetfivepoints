<?php
session_start();
require 'function.php';
require 'cnxDB.php';
if (!empty($_POST)) {
    $errors = array();
    if (empty($_POST['Title'])) {
        $errors['first_name'] = "Entrer le titre ";
    }
    if (empty($_POST['Description'])) {
        $errors['Description'] = "Entrer la Description ";
    }
}
if(isset($_POST['submit'])){
$req = "INSERT INTO posts(Title, Description, Reponse1, Reponse2,Reponse3,userid) VALUES (:Title, :Description, :Reponse1, :Reponse2,:Reponse3,:userid)";
$reponse = $pdo->prepare($req);
$reponse->bindParam(':Title', $_POST['Title']);
$reponse->bindParam(':Description', $_POST['Description']);
$reponse->bindParam(':Reponse1', $_POST['Reponse1']);
$reponse->bindParam(':Reponse2', $_POST['Reponse2']);
$reponse->bindParam(':Reponse3', $_POST['Reponse3']);
$reponse->bindParam(':userid', $_SESSION['auth']['id']);
$reponse->execute();}
//logged();
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <link rel="stylesheet" a href="css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css"
          integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <link rel="stylesheet" href="css/espace-home.css">

</head>
<body>
<nav class="navbar navbar-fixed navbar-dark info-color">

    <!-- Collapse button-->
    <button class="navbar-toggler hidden-sm-up" type="button" data-toggle="collapse" data-target="#collapseEx2">
        <i class="fa fa-bars"></i>
    </button>

    <div class="container">

        <!--Collapse content-->
        <div class="collapse navbar-toggleable-xs" id="collapseEx2">
            <!--Navbar Brand-->
            <!--Links-->
            <ul class="nav navbar-nav">
                <?php if (isset($_SESSION['auth'])): ?>
                    <li class="nav-item active">
                        <a  href="home.php" class="nav-link">Home </a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout </a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="register.php"> Sign Up</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php"> Login</a></li>
                <?php endif; ?>

            </ul>

            <ul class="nav navbar-nav nav-flex-icons">
                <li class="nav-item"><a href="#!" class="nav-link"><i class="fa fa-search" aria-hidden="true"></i></a></li>
                <li class="nav-item"><a href="#!" class="nav-link"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a></li>
            </ul>
        </div>
        <!--/.Collapse content-->

    </div>

</nav>
<!--/.Navbar-->

<main>
    <div class="container">
        <div class="row m-b-r m-t-">

            <div class="col-md-9 offset-md-1">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="Title"  placeholder="Enter Title">
                    </div>
                    <div class="form-group">
                        <label for="Description">Description</label>2
                        <input type="text" class="form-control" name="Description" placeholder="Description">
                    </div>
                    <div class="form-group">
                        <label for="Description">Reponse1</label>
                        <input type="text" class="form-control" name="Reponse1" placeholder="Reponse 1">
                    </div>
                    <div class="form-group">
                        <label for="Description">Reponse2</label>
                        <input type="text" class="form-control" name="Reponse2" placeholder="Reponse 2">
                    </div>
                    <div class="form-group">
                        <label for="Description">Reponse3</label>
                        <input type="text" class="form-control" name="Reponse3" placeholder="Reponse 3">
                    </div>
                    <button type="submit"  name =" submit"class="btn btn-primary"> Submit</button>
                </form>
            </div>
        </div>
        <br>
        <div class="row"><?php
            $requete ="select * from posts " ;
            $req=$pdo->prepare($requete);
            $reponse=$req->execute(array(
            ));

            if (!$reponse){
                return null;
            }
            else{

            }
            $posts=$req->fetchAll(PDO::FETCH_OBJ);

        foreach ($posts
        as $post){
        ?>
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title"> <?= $post->Title; ?></h5>
                    <p class="card-text"><?= $post->Description; ?></p>
                    <form action="vote.php" method="post">
                    <input type="radio" name="vote" value="Reponse1"><?= $post->Reponse1; ?> <br>
                    <input type="radio" name="vote" value="Reponse2"><?= $post->Reponse2; ?> <br>
                    <input type="radio" name="vote" value="Reponse3"><?= $post->Reponse3; ?>
                        <a href="tabStudentStruct.php?IdStruct='.$VAR1.'&StatutChevEl='.$VAR2.'&AnneeScol='.$VAR3.'">git
                        <a  href="vote.php?id='.<?= $post->id;?>.'&Reponse='.<?=$post->Reponse;?>.'">Vote</a>
                    </form>
                </div>
            </div>
            <?php
        }
            ?>
        </div>
        <br>
</main>



</body>
</html>
