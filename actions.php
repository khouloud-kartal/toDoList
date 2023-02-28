<?php
    include('Tasks.php');


    if($_POST && isset($_SESSION)){
        $newTask->Create($_POST['title'], $_SESSION['login']);
        var_dump($_POST['title']);
    }
    
    if(isset($_GET['select'])) {
        $newTask->getInfos($_SESSION['login']);
    }

    if(isset($_GET['delete'])){
        $newTask->delete($_GET['id']);
    }
    
    if(isset($_GET['check'])){
        $newTask->Done($_POST['id']);
    }

    
?>
