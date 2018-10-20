<?php
session_start();
require 'function.php';
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
            <div class="row m-b-r m-t-3">

                <div class="col-md-2 offset-md-1">
                    <img src="upload/<?php echo $_SESSION['auth']['image']; ?>" width="100" height="100">
                </div>
                <div class="col-md-9 p-t-2">
                    <h2 class="h2-responsive"><?php echo ($_SESSION['auth']['first_name']. " " . $_SESSION['auth']['last_name'] ." ")  ;?> <button type="button" class="btn btn-info-outline waves-effect">Follow</button></h2>

                    <ul class="flex-menu">
                        <li><strong>41</strong> posts</li>
                    </ul>
                </div>
            </div>
<br>
            <div class="row">
            </div>
    </main>



</body>
</html>
