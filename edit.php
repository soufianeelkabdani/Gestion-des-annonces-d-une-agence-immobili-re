<?php 
require "connect.php";


echo "<pre>";

print_r($_GET);


echo "</pre>";



$titre = $_GET['annonceName'];
$image = $_GET['annonceImage'];
$description = $_GET['annonceDesc'];
$space = $_GET['annonceSpace']; 
$adresse = $_GET['annonceLocation'];
$price = $_GET['announcePrice'];
$dateDannonce = $_GET['dateDannonce'];
$type = $_GET['category'];
$id = $_GET['id'];






if ( true ){



    $sql = "UPDATE `annonces` 
    SET `titre` = '$titre', `image` = '$image', `description` = '$description', `adresse` = '$adresse', `price` = '$price', `space` = '$space', `dateDannonce` = '$dateDannonce', `type` = '$type'
    
    WHERE `annonces`.`id` = $id; ";

    
    
    // execute a query
    $statement = $conn->query($sql)->execute();
    
    // fetch all rows
    header("location:index.php");

}







