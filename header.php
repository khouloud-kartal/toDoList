<?php
    include('User.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="script.js" defer></script>
    <title>To Do List</title>
</head>
<body>
    
    <header>
        <nav>

            <input type="checkbox" id="check">
            <label for="check" class="checkbtn">
                <i class="fa-solid fa-bars"></i>
            </label>

            <label class="logo">ToDoList</label>
            <ul>
                <li><a class="active" href="./index.php">Home</a></li>
                <li><a href="./register.php">Login</a></li>
                <li><a href="./toDoList.php">To Do</a></li>
                <li><a href="./disconnect">Disconnect</a></li>
                <li><a href="./contact.php">Contact</a></li>
            </ul>
        </nav>
    </header>