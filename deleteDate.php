<?php
include_once "config/User.php";
include_once "config/Database.php";
$db = new Database();
$user = new User();
session_start();

if (isset($_GET['id'])){
    $_SESSION['requireDateID'] =  $_GET['id'];
}
$dateid = $_SESSION['requireDateID'];

// Process delete operation after confirmation
if(isset($_POST["deleteButton"])){

   //deleteDate($dateid);

try {

    $deleteFromTrendingNews = "DELETE FROM trendingnews WHERE dateid = :id";
    $deleteFromTrendingNews = $db->conn->prepare($deleteFromTrendingNews);
    $deleteFromTrendingNews->bindValue(':id', $dateid);
    $deleteFromTrendingNews->execute();


    $deleteFromaCategorywiseNews = "DELETE FROM categorywisenews WHERE dateid = :id";
    $deleteFromaCategorywiseNews = $db->conn->prepare($deleteFromaCategorywiseNews);
    $deleteFromaCategorywiseNews->bindValue(':id', $dateid);
    $deleteFromaCategorywiseNews->execute();


    $deleteFromBreakingNews = "DELETE FROM breakingnews WHERE dateid = :id";
    $deleteFromBreakingNews = $db->conn->prepare($deleteFromBreakingNews);
    $deleteFromBreakingNews->bindValue(':id', $dateid);
    $deleteFromBreakingNews->execute();


            $sql = "DELETE FROM dates WHERE dateid = :id";
            $query = $db->conn->prepare($sql);
            $query->bindValue(':id',$dateid);
            $query->execute();
            $effect = $query->rowCount();

                header("location:  publications.php");

}catch (PDOException $e){
    echo $e->getMessage();
}








}

function deleteDate($date){

     // Prepare a delete statement
    try{
        $sql = "DELETE FROM dates WHERE dateid = :id";
        $query = $db->conn->prepare($sql);
        $query->bindValue(':id',$date);
        $query->execute();

        header("location:  publications.php");




    }catch (PDOException $e){
        echo $e->getMessage();

    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h1>Delete Record</h1>
                </div>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="alert alert-danger fade in">
                        <input type="hidden" name="deleteButton" value=""/>
                        <p>Are you sure you want to delete this record?</p><br>
                        <p>
                            <input type="submit" value="Yes" class="btn btn-danger">
                            <a href="publications.php" class="btn btn-default">No</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>