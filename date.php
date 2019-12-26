<?php
include_once "config/User.php";
include_once "config/Database.php";
session_start();

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
    <a class="navbar-brand" href="#">
        <img src="resources/logo.png" width="35" height="35" class="d-inline-block align-top" alt="">
        News Extended
    </a>



</nav>


<?php

if($_SESSION['login'] != true){

    header("Location: login.php");
   
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['savechanges'])){

    $date = $_POST['date'];
    $_SESSION['selectedDate'] = $date;


    //lets set the date id as session
    try{

        $sql = "SELECT dateid FROM dates where date_ = :date";
        $query = $db->conn->prepare($sql);
        $query->bindValue(':date', $date);
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


    header("Location: home.php");
}
?>


<div class="container pt-5" style="width:400px;">
    <div class="card bg-light text-dark ">
        <div class="card-body" >

            <form action="" method="post" >

                <div >
                    <h1 class="text-sm-center">Please select a date</h1>
                </div>

                <div class="form-group">
                    <center>

                    <select required="true" class="m-4"  name="date">

                        <?php

                        try{

                            $sql = "SELECT * FROM dates";
                            $query = $db->conn->prepare($sql);
                            $query->execute();
                            $query->setFetchMode(PDO::FETCH_ASSOC);

                            while ($row = $query->fetch()){
                                $data = htmlspecialchars($row['date_']);
                                echo " <option >" . $data . "</option>";
                            }

                          /*  if ($_SERVER['REQUEST_METHOD'] == 'POST' &&   isset($_POST['savechanges'])){
                                echo " <option selected>$welcomeText</option>";
                            }else{
                                echo " <option selected>$data</option>";
                                $_SESSION['varname'] = $data;
                            }*/

                        }catch (PDOException $e){
                            echo $e->getMessage();
                        }

                        if(isset($date)){
                            echo " <option selected>" . $date . "</option>";


                        }


                        ?>

                    </select>
                    </center>

                </div>
                <center>
                <div class="form-group">

                    <button type="submit" class="btn btn-dark " name="savechanges">Save Changes</button>
                </div>
                </center>
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