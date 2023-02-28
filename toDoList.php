<?php
    include('header.php');
    include('Tasks.php');

    
    // var_dump($_SESSION);
?>

<main>

    <div class="main-section">
    
        <div class="add-section">
            <div class="error">
                <p><?php echo $newTask->error; ?></p>
            </div>
            <form action="toDoList.php" method="POST" autocomplet="off" id="listForm">
                <input type="text" name="title" id="title" placeholder="Write a Task">
                <button type="submit" id="addTask" name="addTaskBtn">Add &nbsp; <!--<span>&#43;</span>--></button>
            </form>
        </div>

        <div class="showToDoList">
        </div>

        <div class="completedTask showToDoList">
            
        </div>
    </div>
</main>
</body>
</html>