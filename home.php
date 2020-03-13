<?php
include_once "config/User.php";
include_once "config/Database.php";
include_once "mySession.php";
$db = new Database();
$user = new User();
session_start();

$oldpassword = "";

if($_SESSION['login'] == false){
  header("Location: login.php");
}

if(isset($_GET['action']) && $_GET['action'] == "logout"){
  session_destroy();
  header("Location: login.php");
}
?>


<?php
        // Enabling error reporting
        error_reporting(-1);
        ini_set('display_errors', 'On');

        require_once __DIR__ . '/firebase/firebase.php';
        require_once __DIR__ . '/firebase/push.php';

        $firebase = new Firebase();
        $push = new Push();

        // optional payload
        $payload = array();
        $payload['appname'] = 'newsx';
        $payload['author'] = 'salman';

        // notification title
        $title = isset($_GET['title']) ? $_GET['title'] : '';
        
        // notification message
        $message = isset($_GET['message']) ? $_GET['message'] : '';
        
        // push type - single user / topic
        $push_type = isset($_GET['push_type']) ? $_GET['push_type'] : '';
        
      


        $push->setTitle($title);
        $push->setMessage($message);
   
            $push->setImage('');
      
        $push->setIsBackground(FALSE);
        $push->setPayload($payload);


        $json = '';
        $response = '';

        if ($push_type == 'topic') {
            $json = $push->getPush();
            $response = $firebase->sendToTopic('global', $json);
            header("Location: home.php");
            
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

  <!--nav started-->

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
 <a class="navbar-brand" href="#">
    <img src="resources/logo.png" width="35" height="35" class="d-inline-block align-top" alt="">
    News Extended
  </a> 

  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item ">
        <a class="nav-link" href="date.php">Change Date<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item ">
      <a class="nav-link" data-toggle="modal" data-target="#notificationModal">Send Notification<span class="sr-only">(current)</span></a>
      </li>
    </ul>
  </div> 

 
  <div class="btn-group dropleft">
  <button type="button" class="btn  dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
   Config
  </button>
  <div class="dropdown-menu">
    <button class="dropdown-item" type="button" data-toggle="modal" data-target="#myModal">Change Password</button>
    <a href="?action=logout" class="dropdown-item" type="button">Logout</a>
   

    
  </div>
  </div>

</nav>
  <?php
  
  if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])){


    $oldpassword = $_POST['oldPassword'];
  
    try{
              
    
      $sql = "SELECT pass FROM admin WHERE pass = :passwoord";
      $query = $db->conn->prepare($sql);
      $query->bindValue(':passwoord',$oldpassword);
       $query->execute();
  
      if ($query->rowCount() == 0){
          echo "<div class=\"alert alert-danger\" role=\"alert\">Old Password doesn't exist</div>";
      }else{
        $updatePass = $user->update($_POST);
        header("location: home.php");
        echo "changed";
  
  
      }
      }catch(PDOException $e){
          echo $e->getMessage();
  
      }
  
  }
  
  ?>

  <!--nav finished-->

<?php
/*
    $fromDatePage = $_SESSION['selectedDate'];

 if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['savechanges'])){
      //getting date by clicking selected
      $welcomeText = $_POST['date'];
      echo $welcomeText;
      //using session to send data
      //saving in session
      $_SESSION['varname'] = $welcomeText;

      //get the date id of selected date

      try{

          $sql = "SELECT dateid FROM dates where date_ = :datee";
          $query = $db->conn->prepare($sql);
          $query->bindValue(':datee', $_SESSION['varname']);
          $query->execute();
          $query->setFetchMode(PDO::FETCH_ASSOC);
          while ($row = $query->fetch()) {

              $dateid = htmlspecialchars($row['dateid']);

          }
          //put date id in a session !
          $_SESSION['dateid'] = $dateid;

      }catch (PDOException $e){
          echo $e->getMessage();
      }

  }else{
     try{
         $sql = "SELECT dateid FROM dates where date_ = :datee";
         $query = $db->conn->prepare($sql);
         $query->bindValue(':datee',  $fromDatePage);
         $query->execute();
         $query->setFetchMode(PDO::FETCH_ASSOC);
         while ($row = $query->fetch()) {

             $dateid = htmlspecialchars($row['dateid']);

         }
         //put date id in a session !
         $_SESSION['dateid'] = $dateid;

     }catch (PDOException $e){
         echo $e->getMessage();
     }

 }
 */

  ?>

<div >
  <h1 class="text-lg-center display-1">Welcome</h1>
  <h6 class="text-sm-center ">Selected date is <?php echo $_SESSION['selectedDate'];?></h6>
</div>
<!--
 <form method="post" action="">
  <div class="ml-2">

      <select required="true" class="ml-4"  name="date">

        <?php
/*
          try{

              $sql = "SELECT * FROM dates";
              $query = $db->conn->prepare($sql);
              $query->execute();
              $query->setFetchMode(PDO::FETCH_ASSOC);

              while ($row = $query->fetch()){
                  $data = htmlspecialchars($row['date_']);
                  echo " <option >" . $data . "</option>";
              }
              if ($_SERVER['REQUEST_METHOD'] == 'POST' &&   isset($_POST['savechanges'])){
                  echo "<option selected>$welcomeText</option>";
              }else{
                  echo " <option selected>$fromDatePage</option>";
              }

          }catch (PDOException $e){
              echo $e->getMessage();
          }

*/
          ?>

      </select>
  </div>
  </div>
      <div class="ml-2 mt-3">
      <button type="submit" class="btn btn-dark ml-4" name="savechanges">Save Changes</button>
   </div>


  </form> -->



<div class="card-deck pt-5">
<div class="card bg-light ml-5 p-3" style="max-width: 18rem;">
  <div class="card-body">
    <h5 class="card-title"><a style="color:black;"  href="publications.php">Manage Publications</a></h5>


      <?php

      $columnNumber = $user->dateCount();

      if ($columnNumber != 0){
          echo "<p class=\"card-text\">Total ".$columnNumber." newspapers</p>";
      }else{
          echo "<p class=\"card-text\">No newpaper published</p>";
      }

      ?>



</div>
</div>
<div class="card bg-light ml-3 p-3" style="max-width: 18rem;">
  <div class="card-body">
  <h5 class="card-title"><a style="color:black;"  href="categories.php">Manage Categories</a></h5>

      <?php
      $columnNumber = $user->getCategoryCount();
      if ($columnNumber != 0){
          echo "<p class=\"card-text\">Total ".$columnNumber." categories</p>";
      }else{
          echo "<p class=\"card-text\">Please add categories</p>";
      }
      ?>


</div>
</div>
<div class="card bg-light ml-3 p-3" style="max-width: 18rem;">
  <div class="card-body">
  <h5 class="card-title"><a style="color:black;"  href="categorywisenews.php">Add Recent News</a></h5>


      <?php

      $columnNumber = $user->getcategorywisenewscount();
      if ($columnNumber != 0){
          echo "<p class=\"card-text\">".$columnNumber." news today</p>";
      }else{
          echo "<p class=\"card-text\">Please add some todays news!</p>";
      }

      ?>



</div>
</div>
<div class="card bg-light ml-3 p-3" style="max-width: 18rem;">
  <div class="card-body">
  <h5 class="card-title"><a style="color:black;"  href="trendingnews.php">Add Trending News</a></h5>

      <?php
      $columnNumber = $user->trendingNewsCount();
      if ($columnNumber != 0){
          echo "<p class=\"card-text\">".$columnNumber." trending news today</p>";
      }else{
          echo "<p class=\"card-text\">Please add some trending news!</p>";
      }
      ?>



</div>
</div>
<div class="card bg-light mr-5 p-3" style="max-width: 18rem;">
  <div class="card-body">
  <h5 class="card-title"><a style="color:black;"  href="breakingnews.php">Todays Breaking News</a></h5>

      <?php

          $columnNumber =   $user->getbreaknewscount();
      if ($columnNumber != 0){
          echo "<p class=\"card-text\">".$columnNumber." breaking news today</p>";
      }else{
          echo "<p class=\"card-text\">Please add some breaking news!</p>";
      }

      ?>


</div>
</div>
</div>

<div class="card-deck pt-5">
<div class="card bg-light ml-5 " style="max-width: 17rem;">
  <div class="card-body">
  <h5 class="card-title"><a style="color:black;"  href="videomanager.php">Video Manager</a></h5>
    <p class="card-text">12 video in list</p>
</div>
</div>
</div>




<div class="modal fade " aria-hidden="true" data-backdrop="static" data-keyboard="false" id="notificationModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Send Notification</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->

 
      <form action="" method="get" >
      <div class="form-group pt-3" align="center">


      <div>
      <input required="true" type="text" class="form-control" style="width:300px;" id="title" name="title"
       aria-describedby="title" placeholder="Title">
      </div>

      <div class="pt-3">
      <input required="true" type="text" class="form-control" style="width:300px;" id="message" name="message"
       aria-describedby="message" placeholder="Message">
      </div>
   
  </div>
 

      <!-- Modal footer -->
      <div class="modal-footer">
      
        <button type="submit" class="btn btn-dark" value = "topic"  name="push_type" id="push_type">Send</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>

      </div>
      </form>

    </div>
   
  </div>
</div>

-->

<div class="modal fade " aria-hidden="true" data-backdrop="static" data-keyboard="false" id="myModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add New</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->

 
      <form action="" method="post" >
      <div class="form-group pt-3" align="center">


      <div>
      <input required="true" type="password" class="form-control" style="width:300px;" id="oldPassword" name="oldPassword"
       aria-describedby="emailHelp" placeholder="Old Password">
      </div>

      <div class="pt-3">
      <input required="true" type="password" class="form-control" style="width:300px;" id="newPassword" name="newPassword"
       aria-describedby="emailHelp" placeholder="New Password">
      </div>
   
  </div>
 

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="submit" class="btn btn-dark"  name="save" id="save">Save</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>

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

<?php



?>