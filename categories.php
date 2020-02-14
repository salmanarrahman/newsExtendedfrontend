<?php
include_once "config/User.php";
include_once "config/Database.php";
session_start();
if($_SESSION['login'] == false){
  header("Location: login.php");
}



$db = new Database();
$user = new User();
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>News Extended</title>
  </head>
  <body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="home.php">News Extended</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item ">
        <a class="nav-link" href="categories.php">Manage Category <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="recentnews.php">Add News</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="trendingnews.php">Trending</a>
      </li>
      <li class="nav-item">
        <a class="nav-link " href="breakingnews.php">Breaking News</a>
      </li>
       <li class="nav-item">
        <a class="nav-link " href="videomanager.php">Video Manager</a>
      </li>
      <li class="nav-item">
        <a class="nav-link " href="#">Notification</a>
      </li>
    </ul>
  </div>
</nav>



  <?php
  $user = new User();
  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addData'])){
      $category = $user->addCategory($_POST);
      header("Location: categories.php");
  }
  

  ?>

<div  class="pt-5 " align="center" >

<div class="card bg-light  " style="max-width: 50rem;">
  <div class="card-body">
  <div>

  <h1>Total Categories<h1>
</div>
<table class="table table-striped">
    <?php

    if(isset($category)){
        echo $category;
    }

    ?>
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Category</th>
      <th scope="col">Delete</th>
    </tr>
  </thead>
  <tbody>

  <?php
   try{
            $sql = "SELECT * FROM categories";
            $query = $db->conn->prepare($sql);
            $query->execute();
            $query->setFetchMode(PDO::FETCH_ASSOC);
             while ($row = $query->fetch()){
                  echo "<tr>";

                  echo "<td>" . $row['categoryid'] . "</td>";
                  echo "<td>" . $row['category'] . "</td>";

                 echo "<td><a href='deleteCategory.php?id=". $row['categoryid'] ."'> <img src=\"resources/trashcan.png\" width=\"30\" height=\"30\" ></a></td>";


                  echo "</tr>";
                 }
                  echo "</tbody></table>";
            }
            catch (PDOException $e){
             echo $e->getMessage();
        }
  ?>



<div class="float-right">
<!--<a href="#"  type="submit" class="btn btn-dark " role="button"  >Save Changes</a>
-->
<a href="#" type="submit" class="btn btn-dark" role="button" data-toggle="modal" data-target="#myModal">Publish New</a>

</div>

<div class="modal fade " aria-hidden="true" data-backdrop="static" data-keyboard="false" id="myModal">
    <div class="modal-dialog ">
      <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add New</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <form action="" method="post">

      <div class="form-group pt-3">
      <input type="text" class="form-control" style="width:300px;" name="cate" 
       placeholder="Category Name" required="true">
      </div>
          
      <div class="form-group pb-3">
          <button type="submit" class="btn btn-dark" name="addData">Add Data</button>
      <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>

      </div>
     
      </form>

    </div>
  </div>
</div>


</div>
</div>




</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>