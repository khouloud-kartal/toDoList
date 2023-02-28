<?php


class Task
{
    private $conn;

    public function __construct() {

        $db_username = 'root';
        $db_password = '';
        
        // On essaie de se connecter
        try{

            $this->conn = new PDO('mysql:host=localhost;dbname=tdl;charset=utf8', $db_username, $db_password);

            // On définit le mode d'erreur de PDO sur Exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        // On capture les exceptions si une exception est lancée
        catch(PDOException $e){

            // et on affiche les informations relatives à celle-ci
            echo "Error : " . $e->getMessage();

        }

    }

    public function Add($id_utilisateur, $content) {

        $creation_date = date('Y-m-d H:i:s');
        
        $sql = "INSERT INTO taches(`id_utilisateur`, `content`, `isChecked`, `creationDate`) VALUES (:idUtilisateur,:content,:isChecked,:creationDate)";
            
        // Check if a line with the same login exist in our Database.
        $req = $this->conn->prepare($sql);
        $req->execute(array(':idUtilisateur' => $id_utilisateur,
                            ':content' => $content,
                            ':isChecked' => 0,
                            ':creationDate' => $creation_date
        ));
        
        echo 'Task added in the db';

    }

    public function Delete($idTask) {

        $sql = "DELETE FROM taches WHERE id=:idTask";

        $req = $this->conn->prepare($sql);
        $req->execute(array(':idTask' => $idTask));

        echo 'Task deleted from the db';

    }

    public function Check($idTask) {

        $completion_date = date('Y-m-d H:i:s');

        $sql = "UPDATE taches SET isChecked=:isChecked, completionDate=:completionDate WHERE id=:idTask";

        $req = $this->conn->prepare($sql);
        $req->execute(array(':isChecked' => 1,
                            ':completionDate' => $completion_date,
                            ':idTask' => $idTask
        ));

        echo 'Task checked';
        
    }

    public function Uncheck($idTask) {
        
        $sql = "UPDATE taches SET isChecked=:isChecked, completionDate=:completionDate WHERE id=:idTask";

        $req = $this->conn->prepare($sql);
        $req->execute(array(':isChecked' => 0,
                            ':completionDate' => '',
                            ':idTask' => $idTask
        ));

        echo 'Task unchecked';

    }

    public function getAll($id_utilisateur) {

        $sql = "SELECT * FROM taches WHERE id_utilisateur = :idUser";

        $req = $this->conn->prepare($sql);
        $req->execute(array(':idUser' => $id_utilisateur));
        $tab = $req->fetchAll(PDO::FETCH_CLASS);
        
        $json = json_encode($tab, JSON_PRETTY_PRINT);
        echo $json;

    }

}

//$newTask = new Task();
//$newTask->Add(60, 'Ceci est toujours une autre tache');
//$newTask->Delete(6);
//$newTask->getAll(60);

//var_dump($_SESSION);

?>




<!--  -->



<?php

if (session_status() == PHP_SESSION_NONE){ session_start();}
require_once '../Task.php';
$task = new Task;

if(isset($_GET['add'])) {

    $task->Add($_SESSION['id'], $_POST['addTask']);

}

if(isset($_GET['recup'])) {

    $task->getAll($_SESSION['id']);

}

if(isset($_GET['check'])) {

    $task->Check($_POST['idTask']);

}

if(isset($_GET['uncheck'])) {

    $task->Uncheck($_POST['idTask']);

}

if(isset($_GET['delete'])) {

    $task->Delete($_POST['idTask']);

}

?>