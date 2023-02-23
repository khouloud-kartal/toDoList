<?php
    class Tasks{

        // private $id;
        // public $login;
        // public $title;
        // public $description;
        // public $date;
        private $conn;
        var $row;
        var $req;
        var $error;

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

        function Create($title, $iduser){

            if(isset($_SESSION)){

                if($title){
                        date_default_timezone_set("Europe/Paris");
                        $createDate = date("Y-m-d H:i:s");

                        $sql = "INSERT INTO `tasks` VALUES ('?', :title, :createDate , :iduser, '0')";
                        $req = $this->conn->prepare($sql);
                        $req->execute(array(':title' => $title,
                                            ':iduser' => $iduser,
                                            ':createDate' => $createDate
                                        ));
 
                }else{
                    $this->error = 'You have to write something!';
                }
                
            }$this->error =" You have to login to add a task";

        }

        function Delete($idTask){


        }

        function Done($idTask){



        }

        function unDone($idTask){


        }


        function getInfos(){

            $sql = "SELECT * FROM tasks ORDER BY id DESC";
            $this->req = $this->conn->query($sql);

            $this->row = $this->req->rowCount();      

        }


    }

$newTask = new Tasks();
?>