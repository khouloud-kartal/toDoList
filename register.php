<?php
    include('header.php');

    var_dump($_POST);

    if(isset($_POST['submit-log'])){
        $newUser->connect($_POST['logName'],$_POST['logPass']);
    }
    if(isset($_POST['submit-reg'])){
        $newUser->register($_POST['login'],$_POST['password'], $_POST['confirmPassword'], $_POST['email'],);
    }

?>


<main>
    <div class="form-box">

        <div class="button-box">

            <div id="btn"></div>
            <button type="button" class="toggle-btn" id="login-btn">Login</button>
            <button type="button" class="toggle-btn" id="register-btn">register</button>
        </div>

        <form action="register.php" id="login" class="input-group" method="POST">

            <input type="text" class="input-field" placeholder="User Name" name="logName" required>
            <input type="password" class="input-field" placeholder="Password" name="logPass" required>
            <input type="checkbox" class="check-box"><span>Remember Password</span>
            <button type="submit" class="submit-btn" id="subLogin" name="submit-log">Login</button>

        </form>

        <form action="register.php" id="register" class="input-group" method="POST">

            <input type="text" class="input-field" placeholder="User Name" name="login" required>
            <input type="email" class="input-field" placeholder="Email" name="email" required>
            <input type="password" class="input-field" placeholder="Password" name="password" required>
            <input type="password" class="input-field" placeholder="Confirm Password" name="confirmPassword" required>
            <input type="checkbox" class="check-box"><span>I agree to the terms & conditions</span>
            <button type="submit" class="submit-btn" id="subRegister" name="submit-reg">Register</button>

        </form>
    </div>
</main>
</body>
</html>