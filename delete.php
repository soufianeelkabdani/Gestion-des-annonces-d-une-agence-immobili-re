<?php 
// connect to the database to get the PDO instance
require "connect.php";

if (isset($_GET['annonceId']) ){


    $id = $_GET['annonceId'];

    $deleteSQL = "DELETE FROM `annonces` WHERE `annonces`.`id` = $id " ;
    
    // execute a query
    $statement = $conn->query($deleteSQL)->execute();;
    
    // fetch all rows

    header("location:index.php");

} else{

    header("location:error.php");

}










