<?php 
require "connect.php";


// echo "<pre>";

// print_r($_GET);


// echo "</pre>";


$titre = $_POST['annonceName'];
$image = $_POST["annonceImage"];
$description = $_POST['annonceDesc'];
$space = $_POST['annonceSpace']; 
$adresse = $_POST['annonceLocation'];
$price = $_POST['announcePrice'];
$dateDannonce = $_POST['annonceDate'];
$type = $_POST['category'];




$sql = "INSERT INTO `annonces` 
(`titre`, `image`, `description`, `space`, `adresse`, `price`, `dateDannonce`, `type`) 
VALUES 
('$titre' , '$image', '$description', $space, '$adresse', $price, $dateDannonce, '$type')";
// execute a query
$conn->query($sql)->fetch();




header("location:index.php");
