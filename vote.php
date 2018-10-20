<?php
require_once 'function.php';
require "cnxDB.php";

var_dump($_GET['Reponse']);
if(isset($_POST['vote'])){
    $req = "INSERT INTO votes(Title, Description, Reponse,userid) VALUES (:Title, :Description, :Reponse,:userid)";
    $reponse = $pdo->prepare($req);
    $reponse->bindParam(':Title', $_POST['Title']);
    $reponse->bindParam(':Description', $_POST['Description']);
    $reponse->bindParam(':Reponse', $_POST['Reponse']);
    $reponse->bindParam(':userid', $_SESSION['auth']['id']);
    $reponse->execute(
        array(
            'Title'=>$_POST['Title'],
            'Description'=>$_POST['Description'],
            'Reponse'=> $_POST['Reponse'],
            'userid'=>$_SESSION['auth']['id']
        )
    );}
//logged();
?>