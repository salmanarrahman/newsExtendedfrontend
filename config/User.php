<?php

include "Database.php";
class User{
    private $db;
    public function  __construct(){
        $this->db = new Database();
    }

    public function dateCount(){
        try{

            $sql = "SELECT COUNT(dateid) FROM dates";
            $query = $this->db->conn->prepare($sql);
            $query->execute();
            $columnNumber = $query->fetchColumn();

            return $columnNumber;

        }catch (PDOException $e){
            return $e->getMessage();
        }
    }

    public function getCategoryCount(){
        try{

            $sql = "SELECT COUNT(category) FROM categories";
            $query = $this->db->conn->prepare($sql);
            $query->execute();
            $columnNumber = $query->fetchColumn();

            return $columnNumber;
        }catch (PDOException $e){
            return $e->getMessage();
        }
    }

    public  function  trendingNewsCount(){
        try{
            $id = $_SESSION['dateid'];
            $sql = "SELECT COUNT(headline) FROM trendingnews WHERE dateid = :date_id";
            $query = $this->db->conn->prepare($sql);
            //     $query -> bindVlue(":date_id",$dateid);
            $query->bindValue(':date_id',$id);
            $query->execute();
            $columnNumber = $query->fetchColumn();

           return $columnNumber;
        }catch (PDOException $e){
            return $e->getMessage();
        }
    }

    public function getcategorywisenewscount(){
        try{

            $id = $_SESSION['dateid'];
            $sql = "SELECT COUNT(headline) FROM categorywisenews WHERE dateid = :date_id";
            $query = $this->db->conn->prepare($sql);
            //     $query -> bindVlue(":date_id",$dateid);
            $query->bindValue(':date_id',$id);
            $query->execute();
            $columnNumber = $query->fetchColumn();

            return $columnNumber;
        }catch (PDOException $e){
            return $e->getMessage();
        }
    }

    //get the fucing count of breaking news
    public function getbreaknewscount(){
        try{
            $id = $_SESSION['dateid'];

            $sql = "SELECT COUNT(headline) FROM breakingnews WHERE dateid = :date_id";
            $query = $this->db->conn->prepare($sql);
            //     $query -> bindVlue(":date_id",$dateid);
            $query->bindValue(':date_id',$id);
            $query->execute();
            $columnNumber = $query->fetchColumn();


            return $columnNumber;

        }catch (PDOException $e){
            return $e->getMessage();
        }

    }

    //add category
    public function addCategory($data) {
        $ctg = $data['cate'];
        $check_category = $this->categoryCheck($ctg);
        if ($check_category != true){
            //id the name doesnt match then add data in table
            try{

                $sql = "insert into categories (category) values(:ctg)";
                $query = $this->db->conn->prepare($sql);
                $query->bindValue(':ctg',$ctg);
                $result = $query->execute();

            }catch (PDOException $e){
                echo $e->getmessage();
            }

        }else{

            echo "<div class=\"alert alert-danger\" role=\"alert\">Category Name Alredy Exist</div>";

        }

    }
    //function ends here





    public  function categoryCheck($ctg){
        $sql = "SELECT category FROM categories WHERE category = :ctg";
        $query = $this->db->conn->prepare($sql);
        $query->bindValue(':ctg',$ctg);
         $query->execute();

        if ($query->rowCount() > 0){
            return true;
        }else{
            return false;
        }

    }

    public function getDateID(){


        $date = $_SESSION['varname'];

        try{
            $sql = "SELECT dateid FROM dates WHERE date_ = :date";
            $query = $this->db->conn->prepare($sql);
            $query->bindValue(':date',$date);
            $query->execute();
            $row = $query->fetch(PDO::FETCH_ASSOC);

            $data = $row['dateid'];

            return $data;
        }
        catch (PDOException $e){
           echo $e->getMessage();
        }

    }

    public function addDate($date){
        $data = $date['date'];

        $checkDate = $this->dateCheck($data);

        if($checkDate != true){

            try{

                $sql = "insert into dates (date_) values(:mydate)";
                $query = $this->db->conn->prepare($sql);
                $query->bindValue(':mydate',$data);
                $result = $query->execute();

                header("Location: config/Database.php");

            }catch (PDOException $e){
                echo $e->getmessage();
            }

        }else{

            echo "<div class=\" alert alert-danger\"role=\"alert\">Date Alredy Exist</div>";

        }


    }

    public function dateCheck($getTheDate){
        $sql = "SELECT dateid FROM dates WHERE date_ = :date";
        $query = $this->db->conn->prepare($sql);
        $query->bindValue(':date',$getTheDate);
        $query->execute();

        if ($query->rowCount() > 0){
            return true;
        }else{
            return false;
        }

    }



    public function videoInfo($data,$photo){

        $dateid = $_SESSION['dateid'];
        $videoaddress = $data['videoAddress'];
        $title  = $data['videoTitle'];
        $cameraman = $data['cameraman'];
        $news  = $data['news'];
        $thumbnail = $photo;

                try {
                    $sql = "insert into video (videoaddress,title,cameraman,news,thumbnail,dateid)
                                 values(:videoaddress, :title,:cameraman,:news,:thumbnail,".$dateid  ." )";
                    $query = $this->db->conn->prepare($sql);
                    $query->bindValue(':videoaddress', $videoaddress);
                    $query->bindValue(':title', $title);
                    $query->bindValue(":cameraman", $cameraman);
                    $query->bindValue(":news", $news);
                    $query->bindValue(':thumbnail', $thumbnail);
                    $query->execute();
                }catch (PDOException $e){
                    echo $e->getMessage();
                }

            }


    public function addAllTrendingNews($data,$photo){

        $dateid = $_SESSION['dateid'];

        $headline = $data['trendingNewsHeadline'];
        $news  = $data['trendingNews'];
        $reporter = $data['trendingReporter'];
        $uploaded_image = $photo;


                try {
                    $sql = "insert into trendingnews (dateid,headline,news,reporter,thumbnail)
                                 values(".$dateid  .", :headline,:reporter,:news,:thumbnail )";
                    $query = $this->db->conn->prepare($sql);
                    $query->bindValue(':headline', $headline);
                    $query->bindValue(':reporter', $reporter);
                    $query->bindValue(":news", $news);
                    $query->bindValue(':thumbnail', $uploaded_image);
                    $query->execute();
                }catch (PDOException $e){
                    echo $e->getMessage();
                }

            }


    public function addAllBreakingNews($data,$photo){

        $dateid = $_SESSION['dateid'];

        $headline = $data['breakingNewsHeadline'];
        $news  = $data['breakingNews'];
        $reporter = $data['breakingNewsReporter'];
        $uploaded_image = $photo;


        try {
            $sql = "insert into breakingnews (dateid,headline,news,reporter,thumbnail)
                                 values(".$dateid  .", :headline,:reporter,:news,:thumbnail )";
            $query = $this->db->conn->prepare($sql);
            $query->bindValue(':headline', $headline);
            $query->bindValue(':reporter', $reporter);
            $query->bindValue(":news", $news);
            $query->bindValue(':thumbnail', $uploaded_image);
            $query->execute();
        }catch (PDOException $e){
            echo $e->getMessage();
        }

    }



    //add category wise news
    public function addAll($data,$a){
        $dateid = $_SESSION['dateid'];
        $dropdown = $data['dropdown'];
        $headline = $data['headline'];
        $news  = $data['news'];
        $reporter = $data['reporter'];
        $uploaded_image = $a ;
        try{

            $sql = "SELECT categoryid FROM categories WHERE category = :ctg";
            $query = $this->db->conn->prepare($sql);
            $query->bindValue(':ctg', $dropdown);
            $query->execute();
            $query->setFetchMode(PDO::FETCH_ASSOC);
            //   $dateid = $this->getDateID();

            while ($row = $query->fetch()) {
                try {
                    $sql = "insert into categorywisenews (dateid,categoryid,headline,reporter,news,thumbnail)
                                 values(".$dateid.",".$row['categoryid'].",:headline,:reporter,:news,:thumbnail )";
                    $query = $this->db->conn->prepare($sql);
                    $query->bindValue(':headline', $headline);
                    $query->bindValue(':reporter', $reporter);
                    $query->bindValue(":news", $news);
                    $query->bindValue(':thumbnail', $uploaded_image);
                    $query->execute();
                }catch (PDOException $e){
                    echo $e->getMessage();
                }

            }


        }catch (PDOException $e){
            echo $e->getmessage();
        }

    }
    //end of the function

        public function update($data){

            try{
            $oldPassword = $data['oldPassword'];
            $newPassword = $data['newPassword'];

            $query = "UPDATE admin SET pass = :newPass WHERE pass = :oldPass";
            $query = $this->db->conn->prepare($query);
            $query->bindValue(":newPass",$newPassword);
            $query->bindValue(":oldPass",$oldPassword);
            $query->execute();
            }catch(PDOException $e){
                echo $e->getMessage();

            }

            return "Sucess";

                          

        }

}

?>


