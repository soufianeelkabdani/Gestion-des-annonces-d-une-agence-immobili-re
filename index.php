<?php 
// connect to the database to get the PDO instance
require "connect.php";
// SELECT * FROM `annonces` LIMIT 6 OFFSET 0; 
if(isset($_GET["pageId"]) ){
$endIndex = 6 * $_GET["pageId"];
$startIndex = $endIndex  - 6 ;
$sql = "SELECT * FROM `annonces` LIMIT 6  OFFSET $startIndex " ;
// execute a query
$statement = $conn->query($sql);
// fetch all rows
$annonce = $statement->fetchAll(PDO::FETCH_ASSOC);
}else {
  $sql = 'SELECT * FROM `annonces` LIMIT 6 OFFSET 0' ;
  // execute a query
  $statement = $conn->query($sql);
  // fetch all rows
  $annonce = $statement->fetchAll(PDO::FETCH_ASSOC);
}
$sql = 'SELECT COUNT(*) FROM `annonces` ';
$annoncesLength = $conn->query($sql)->fetch();
$pagesNum = 0;
if(($annoncesLength[0] % 6 ) == 0){
  $pagesNum = $annoncesLength[0] / 6 ;
}  else{
  $pagesNum = ceil($annoncesLength[0] / 6);
}
if(isset($_POST['search'])){
    $type = $_POST['type'];
    $priceMax = $_POST['priceMax'];
    $priceMin = $_POST['priceMin'];
    $sql= "SELECT * FROM `annonces` WHERE `price` >= $priceMin   AND `price` <= $priceMax  AND `type`  LIKE '$type' ";
    $statement = $conn->query($sql);
    // fetch all rows
    $annonce = $statement->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
  <div
    class="hero page-inner overlay"
    style="background-image: url('images/hero_bg_1.jpg')">
  
  <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
      <div class="container slideTop">
        <div class="row justify-content-center align-items-center">
          <div class="col-12 col-md-9 text-center mt-5">
            <div class="row justify-content-center align-items-center mb-5">
                <h1 class="mt-5 text-light" >
                Easiest way to find your dream home
                </h1>
                <div class="row text-center mt-3">
                <div class="col input-group">
                  <select name="type" class="form-select" id="inputGroupSelect01">
                    <option selected>Choose...</option>
                    <option value="louer">louer</option>
                    <option  value="vendre">vendre</option>
                  </select>
                </div>

                <div class="col input-group">
                  <input type="number" name="priceMax"  class="form-control" placeholder="Max"/>
                  <input type="number" name="priceMin"  class="form-control" placeholder="Min"/>
                </div>
                <input type="submit" name="search" class="btn btn-ajouter col" value="Search">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>

<section class="container ">

<div class="buttons mt-4 text text-center ">
  <button type="button" class="btn btn-ajouter my-1" data-bs-toggle="modal" data-bs-target="#addAnnonce">Ajouter un acrticle</button>
  <a type="button" class="btn btn-danger  text-center mx-auto my-1" data-bs-toggle="modal" data-bs-target="#factoryModal" >MAKE FACTORY DATA</a>
</div>

  <div class="row justify-content-between container  mt-5">
  <?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {

  foreach ($annonce as $key => $value) {

    ?>
    <div class="card mt-3 mx-auto" style="width: 20rem;">
      <div class="img-zoom">
        <img src="<?php echo $value['image']; ?>" class="card-img-top" alt="image" style="overflow: hidden;">
      </div>
      <div class="card-body">
        <div class="card-title"><span><?php echo $value['price'] ; ?> Dhs</span></div>
  
        <p class="card-text mt-3"><?php echo $value['adresse']; ?></p>
        <div class="card-city"><span><?php echo $value['titre']; ?></span></div>
        <p>
          <a class="text-secondary" href="detail.php?pageId= <?php echo $value['id']; ?>" > more details...</a>
        </p>
        <a 
        class="btn  mt-3 icon"data-bs-toggle="modal"data-bs-target="#EditAnnounce">  
        <i class="fa-solid fa-pen-to-square" onclick="editAnnonce(<?php echo $value['id']; ?>)"></i>
        </a>
        <a
        class="btn  mt-3 icon" data-bs-toggle="modal" data-bs-target="#deleteAnnonce">
          <i class="fa-solid fa-trash" onclick="deleteAnnonce(<?php echo $value['id']; ?>)"  ></i>
        </a>
  
      </div>
    </div>

    <?php

  }

}elseif ($_SERVER["REQUEST_METHOD"] == "POST") {

  foreach ($annonce as $key => $value) {

    ?>
    <div class="card mt-3 mx-auto" style="width: 20rem;">
      <div class="img-zoom">
        <img src="<?php echo $value['image']; ?>" class="card-img-top" alt="image" style="overflow: hidden;">
      </div>
      <div class="card-body">
        <div class="card-title">
          <span><?php echo $value['price'] ."Dhs";?> </span>
        </div>
          <p class="card-text mt-3"><?php echo $value['adresse']; ?></p>
        <div class="card-city"><span><?php echo $value['titre']; ?></span></div>
        <p>
          <a class="text-secondary" href=" detail.php?pageId= <?php echo $value['id']; ?>" > more details...</a>
        </p>
        <a class="btn  mt-3 icon" data-bs-toggle="modal" data-bs-target="#EditAnnounce">
          <i class="fa-solid fa-pen-to-square" onclick="editAnnonce(<?php echo $value['id']; ?>)"></i>
        </a>
        <a class="btn  mt-3 icon" data-bs-toggle="modal" data-bs-target="#deleteAnnonce">
          <i class="fa-solid fa-trash" onclick="deleteAnnonce(<?php echo $value['id']; ?>)"  ></i>
        </a>
      </div>
    </div>
    <?php
  }
}
  ?>
</section>
<!-- add annonce  -->
<div class="modal fade" id="addAnnonce" tabindex="-1" aria-labelledby="addAnnonce" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Annonce</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <form action="addArticle.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="recipient-name" class="col-form-label" required>Announce Name :</label>
              <input type="text" name="annonceName" class="form-control" id="announce-name">
            </div>
            <div class="mb-3">
              <label for="recipient-name" class="col-form-label" required>Announce Price :</label>
              <input type="number" name="announcePrice" min="0" class="form-control" id="announce-price" required>
            </div>
            <div class="mb-3">
              <div class="mb-3">
                <label for="recipient-name"  class="col-form-label">Announce Picture :</label>
                <input type="text" name="annonceImage" class="form-control" id="announce-pic" placeholder="Type URL here..">
              </div> 
              <!-- <div class="mb-3">
                <label for="formFile" class="form-label" >Default file input example</label>
                <input class="form-control" name="fileToUpload" type="file" id="formFile" required>
              </div> !-->
              <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Announce Category :</label>
                <select class="form-select input-xs " name="category" id="category" required>
                  <option selected>Category</option>
                  <option name="Alouer" value="louer">A louer</option>
                  <option name="Avendre" value="vendre">A vendre</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Announce Location :</label>
                <input type="text" name="annonceLocation"  class="form-control" id="announce-name" required>
              </div>
              <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Announce space :</label>
                <input type="number" name="annonceSpace" min="0" class="form-control" id="announce-name" required>
              </div>
              <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Announce Date :</label>
                <input type="date" name="annonceDate" class="form-control" id="announce-date" required>
              </div>
              <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Announce Description :</label>
                <textarea class="form-control" name="annonceDesc" id="announce-desc" required></textarea>
              </div>

            </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">cancel</button>
                <input type="submit"  href="" name="add" class="btn btn-primary botton" value="Add">
              </div>
            </div>
        </form>
    </div>
  </div>
</div>
<!-- modal delete  -->
<div class="modal fade" id="deleteAnnonce" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Annonce</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">are u sure</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">cancel</button>
        <a type="button"  id="deleteBtn" href="" class="btn btn-primary botton">Delete</a>
      </div>
    </div>
  </div>
</div>
<?php
if($_SERVER["REQUEST_METHOD"] == "GET"){
?>

<nav class="mt-4 mb-4 " aria-label="Page navigation example">
  <ul class="pagination justify-content-center">
<?php
for ($i=1; $i <= $pagesNum; $i++) { 
  ?>
    <li class="page-item"><a class="page-link" href="<?php echo "index.php?pageId=".$i?>"><?php echo $i ;?></a></li>
<?php
}
?>
  </ul>
</nav>
<?php
}
?>
<!-- Modal Edite-->
<div class="modal fade" id="EditAnnounce" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modalBody">

      
      <form action="edit.php" method="GET">
      <div class="mb-3">
        <label for="recipient-name" class="col-form-label">Announce Name :</label>
        <input type="text" name="annonceName" class="form-control"  id="announce-Title" required>
      </div>
      <div class="mb-3">
        <label for="recipient-name" class="col-form-label">Announce Price :</label>
        <input type="number" name="announcePrice" class="form-control" min="0" id="announce-price" required>
      </div>
      <div class="mb-3">
        <div class="mb-3">
          <label for="recipient-name"  class="col-form-label">Announce Picture :</label>
          <input type="text" name="annonceImage" class="form-control" id="announce-image" placeholder="Type URL here.." required>
        </div>
        <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Announce space :</label>
                <input type="number" name="annonceSpace"  class="form-control" min="0" id="announce-space" required>
              </div>
        <div class="mb-3">
          <label for="recipient-name" class="col-form-label">Announce Category :</label>
          <select class="form-select input-xs " name="category" id="category" required>
            <option selected>Category</option>
            <option value="louer">louer</option>
            <option value="vendre">vendre</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="recipient-name" class="col-form-label">Announce Location :</label>
          <input type="text" name="annonceLocation"  class="form-control" id="announce-local" required> 
        </div>
        <div class="mb-3">
          <label for="recipient-name" class="col-form-label">Announce Date :</label>
          <input type="date" name="annonceDate" class="form-control" id="announce-date" required>
        </div>
        <div class="mb-3">
          <label for="recipient-name" class="col-form-label">Announce Description :</label>
          <textarea class="form-control" name="annonceDesc" id="announce-desc" required></textarea>
        </div>
        <input type="hidden" name="id" id="hiddenId" value="">
      </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">cancel</button>
        
          <input type="submit"   name="save" class="btn btn-primary botton" value="Save">
        </div>
      </div>
      
    </form>

      </div>
    </div>
  </div>
</div>
<!-- Modal factory -->
<div class="modal fade" id="factoryModal" tabindex="-1" aria-labelledby="factoryModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="factoryModal">Make factory data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="Factory.php" method="post">
            <input  type="number" name="dataNumber" min="6" max="24">
          </div>
          <div class="modal-footer">
            <button 
            type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Close</button>
            <button type="submit" class="btn btn-primary botton">Add a rows</button>
          </div>
        </form>
      </div>
    </div>
</div>
<script src="script.js"></script> 
<script src="https://kit.fontawesome.com/eec721374e.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
