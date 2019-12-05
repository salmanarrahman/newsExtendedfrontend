<?php
include_once "config/User.php";
include_once "config/Database.php";
$db = new Database();
$user = new User();
session_start();

if (isset($_GET['id'])){
    $_SESSION['requireCategoryID'] =  $_GET['id'];
}
$categoryid = $_SESSION['requireCategoryID'];

// Process delete operation after confirmation
if(isset($_POST["deleteButton"])){

    //deleteDate($dateid);

    try {




        $sql = "DELETE FROM categories WHERE categoryid = :id";
        $query = $db->conn->prepare($sql);
        $query->bindValue(':id',$categoryid);
        $query->execute();
        $effect = $query->rowCount();


        header("location:  categories.php");

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
                        <p>Are you sure you want to delete this category?</p><br>
                        <p>
                            <input type="submit" value="Yes" class="btn btn-danger">
                            <a href="categories.php" class="btn btn-default">No</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>