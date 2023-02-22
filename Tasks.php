<?php
    session_start();
    class Tasks{

        private $id;
        public $login;
        public $title;
        public $description;
        public $date;
        private $conn;

        function __construct(){
            
            $db_username = 'root';
            $db_password = '';

            try{

                $this->conn = new PDO('mysql:host=localhost;dbname=todolist;charset=utf8', $db_username, $db_password);


                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


                // echo "You are connected to the database <br>";
            }

            catch(PDOException $e){

                echo "Error : " . $e->getMessage();

            }
        }

        function Create($title, $description, $date, $iduser){

            $errorDate = "";

            $sql = "SELECT * FROM taches INNER JOIN users ON taches.iduser = users.id";

            $req = $this->conn->prepare($sql);
            $req->execute();

        }
    }

$newTask = new Tasks();
?>