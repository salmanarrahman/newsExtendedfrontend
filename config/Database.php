<?php

    class Database{

        private $host = 'localhost';
        private $username = 'root';
        private $db_name = 'newsextended';
        private $password = '';
        public  $conn;

        //db connect
        public function __construct(){
            $this->conn = null;

            try{

                $dsn = 'mysql:host='. $this->host .';dbname='. $this->db_name;
                $this->conn = new PDO($dsn,$this->username,$this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            }catch(PDOException $e){
                echo 'Connection Error: ' . $e->getMessage();
                echo '\nERR';
            }

            return $this->conn;

        }
    }

?>