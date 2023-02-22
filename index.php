<?php
    include('header.php');
?>
<main>
    <h1 class="homeTitle">Welcome <?php if(isset($_SESSION)){ echo $_SESSION['login'];}?></h1>
</main>
</body>
</html>