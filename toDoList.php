<?php
    include('header.php');
    // include('Tasks.php');

    // // var_dump($_SESSION);

    // if(isset($_POST['addTaskBtn']) && $_SESSION){
    //     $newTask->Create($_POST['title'], $_SESSION['login']);
    // }
    
    // $newTask->getInfos();
?>

<main>

    <div class="main-section">
    
        <div class="add-section">
            <div class="error">
                <p><?php echo $newTask->error?></p>
            </div>
            <form action="" method="POST" autocomplet="off">
                <input type="text" name="title" id="title" placeholder="Write a Task">
                <button type="submit" id="addTask" name="addTaskBtn">Add &nbsp; <!--<span>&#43;</span>--></button>
            </form>
        </div>

        <div class="showToDoList">
            <?php 
                $row = $newTask->row;
                if($row < 0){ ?>
            <div class="toDoItems">
                <div class="empty">
                    <img src="./simpsonNotes.gif" alt="Simpson reading his not">
                </div>
            </div>
            <?php }?>

            <?php 
                foreach ($newTask->req as $var) { ?>
                    
                    <div class="toDoItems">
                        <!-- get each id task and let it hidden to delete easily with its id -->
                        <button id='<?php echo $var['id']?>' class="remove-to-do">x</button>
                        <?php
                            if($var['checked']){?>
                            <input type="checkbox" class="check-box" checked>
                            <h2 class="checked"><?php echo $var['title'];?></h2>
                        <?php }else{?>
                            <input type="checkbox" class="check-box" >
                            <h2><?php echo $var['title'];?></h2>
                        <?php }?>
                        <small>Created: <?php echo $var['createDate']; ?></small>
                        <small>by: <?php echo $var['iduser']; ?></small>
                    </div>   
            
            <?php } ?>
        </div>


    </div>
</main>
</body>
</html>