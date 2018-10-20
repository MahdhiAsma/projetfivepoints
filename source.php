<?php
// include database connection
include "cnxDB.php";

// select the image


$stmt = $pdo->prepare( "SELECT * from users WHERE id = ?");

// bind the id of the image you want to select
$stmt->bindParam(1, $_GET['id']);
$stmt->execute();

// to verify if a record is found

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // specify header with content type,
    // you can do header("Content-type: image/jpg"); for jpg,
    // header("Content-type: image/gif"); for gif, etc.
    header("Content-type: image/jpg");

    //display the image data
    print $row['image'];

    exit;


