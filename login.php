<?php
include_once "config/User.php";
include_once "config/Database.php";

session_start();

$db = new Database();
$user = new User();



$db_name = "admin";
$emailDerived = "";
$passwordDerived = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])){

      $email = $_POST['email'];
      $password = $_POST['password'];

      try{

        $sql = "SELECT * FROM ".$db_name." WHERE user_name = :email AND pass = :pass LIMIT 1";
        $query = $db->conn->prepare($sql);
        $query->bindValue(':email', $email);
        $query->bindValue(':pass',$password);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);      

        while ($row = $query->fetch()) {

          if($row['user_name'] != null && $row['pass'] != null){
          $emailDerived = $row['user_name'];
          $passwordDerived = $row['pass'];   

          }       
        }
        if($email == $emailDerived && $password == $passwordDerived){
        //  mySession::set("login",true);
          $_SESSION['login'] = "true";
          header('Location: date.php');
        }else{
          echo "didn't match";
        }    
       
    }catch (PDOException $e){
        echo $e->getmessage();
    }   
   
}
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
 <a class="navbar-brand" href="#">
    <img src="resources/logo.png" width="35" height="35" class="d-inline-block align-top" alt="">
    News Extended
  </a> 
</nav>

<div class="container pt-5" style="width:400px;">
  <div class="card bg-light text-dark ">
    <div class="card-body" >

  <form action="" method="post">
  <div class="form-group" type="POST">
    <label for="exampleInputEmail1">Email address</label>
    <input required="" type="email" class="form-control" style="width:300px;"
     id="email" aria-describedby="emailHelp" name="email" placeholder="Enter email">
   
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input required="true" type="password" style="width:300px;" 
    class="form-control" id="password" name="password" placeholder="Password">
  </div>
  <div class="form-group">
  <button href="home.php"  type="submit"  class="btn btn-dark" id="login" name="login" >Login</button>
  </div>
</form>

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