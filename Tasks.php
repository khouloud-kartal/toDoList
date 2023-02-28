<?php

    if(session_status() == PHP_SESSION_NONE){ session_start();}

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
 
                        echo 'the task is added';
                        
                }else{
                    $this->error = 'You have to write something!';
                    echo 'You have to write something!';
                }
                
            }$this->error =" You have to login to add a task";
            echo 'You have to login to add a task';

        }

        function Delete($idTask){

            $req = $this->conn->prepare("DELETE FROM tasks WHERE id = :id");
            $req->execute(array(':id' => $idTask));

        }

        function Done($idTask){

            if(isset($idTask)){

                echo'it is done';

                $sql = "UPDATE tasks SET checked=:checked WHERE id=:id";

                $req = $this->conn->prepare($sql);
                $req->execute(array(':checked' => 1,
                                    ':id' => $idTask
                ));
            }else{
                echo' erreur de requete';
            }


        }

        function unDone($idTask){


        }


        function getInfos($iduser){

            $req = $this->conn->prepare("SELECT *, tasks.id FROM tasks INNER JOIN users ON users.login = tasks.iduser WHERE iduser = :iduser AND checked = :checked ORDER BY tasks.id DESC");
            $req->execute([
                ":iduser" => $iduser,
                ":checked" => '0'
            ]);
            $result = $req->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($result);

            die();

            // $this->row = $this->req->rowCount(); 
            
            // $sql = "SELECT * FROM tasks ORDER BY id DESC";
            // $this->req = $this->conn->query($sql);

            // $this->row = $this->req->rowCount();    

        }

        function update($idTask){
            $req = $this->conn->prepare("UPDATE tasks SET `checked` = :checked WHERE `id` = :id");
            $req->execute([
                    ":checked" => 1,
                    ":id" => $idTask
            ]);
        }


    }

$newTask = new Tasks();
?>