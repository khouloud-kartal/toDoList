<?php

session_start();

class User
{
    private $id;
    public $login;
    public $email;
    public $firstname;
    public $lastname;
    private $conn;
    var $error;

    public function __construct() {

        $db_username = 'root';
        $db_password = '';

        try{

            $this->conn = new PDO('mysql:host=localhost;dbname=todolist;charset=utf8', $db_username, $db_password);


            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


            //echo "You are connected to the database <br>";
        }

        catch(PDOException $e){

            echo "Error : " . $e->getMessage();

        }
        

    }

    public function Register($login, $password, $passwordConfirm, $email) {

        $error = "";
        $errorLogin = "";
        $errorPassword = "";
        $errorEmail = "";

        $sql = "SELECT * FROM users WHERE login=:login";
       
        $req = $this->conn->prepare($sql);
        $req->execute(array(':login' => $login));
        $row = $req->rowCount();
        
        if($row <= 0) {    
            if(strlen($login) >= 4 && !preg_match("[\W]", $login) && strlen($password) >= 5 && preg_match("/@/", $email) && preg_match("/\./", $email)) {

                if($password == $passwordConfirm) {
                    
                    $hash = password_hash($password, PASSWORD_DEFAULT);

                    $hash = password_hash($password, PASSWORD_DEFAULT);

                    $sql = "INSERT INTO `users` (`login`, `password`, `email`) VALUES (:login, :pass, :email)";
                    $req = $this->conn->prepare($sql);
                    $req->execute(array(':login' => $login,
                                        ':pass' => $hash,
                                        ':email' => $email,));

                    $this->error = 'Success! Your account is now created and you can login';
                                        
                    $userData = [
                        'login' => $login,
                        'password' => $hash,
                        'email' => $email
                    ];

                    return $userData;

                }else{ $this->error = 'The passwords do not match'; }

            }else{

                if(strlen($login) < 4 || preg_match("[\W]", $login)) {

                    $this->error = "Your login must contain at least 4 caracters and no specials caracters";

                }

                if(strlen($password) < 5) {

                    $this->error = "Your password must contain at least 5 caracters";

                }

                if(!preg_match("/@/", $email) || !preg_match("/\./", $email)) {

                    $this->error = "Your email is not valid. It must contain '@' and '.'";

                }

            }
            
        }else{ $this->error = 'Error! The login already exist. Please choose another one '; }

        return $error . $errorLogin . $errorPassword . $errorEmail ;

    }

    public function Connect($login, $password) {

        $sql = "SELECT * FROM users WHERE login=:login";
        
        $req = $this->conn->prepare($sql);
        $req->execute(array(':login' => $login));
        $row = $req->rowCount();

        if($row == 1){    

            $tab = $req->fetch(PDO::FETCH_ASSOC);
            $dataPass = $tab['password'];
            $id = $tab['id'];

            if(password_verify($password,$dataPass)){   

                $_SESSION['id'] = $id;
                $_SESSION['login'] = $login;
                $_SESSION['password'] = $dataPass;
                $_SESSION['email'] = $tab['email'];

                header('Location: index.php');

                // echo '<strong>Success!</strong> You\'re connected<br>';

            }else{   
                $this->error = 'Error! Wrong password<br>';
            }
        }else{    
            $this->error = 'Error! The login do not exist.';
        }

    }

    public function Disconnect() {

        session_destroy();
        header('Location: ./register.php');
        exit('Vous avez bien été deconnecté');

    }

    public function Delete() {

        if($_SESSION){

            $sessionId = $_SESSION['id'];

            $sql = "DELETE FROM `utilisateurs` WHERE id = :sessionId";
        
            $req = $this->conn->prepare($sql);
            $req->execute(array(':sessionId' => $sessionId));

            session_destroy();
            exit('You have deleted your account');


        }else{
            $this->error = 'Please login to delete your account<br>';
        }

    }

    public function Update($login, $password, $passwordNew, $passwordNewConfirm, $email, $firstname, $lastname) {

        $error = "";
        $errorLogin = "";
        $errorPassword = "";
        $errorEmail = "";

        if ($_SESSION){

            $sessionId = $_SESSION['id'];
            $passwordTrue = $_SESSION['password'];

            $sql = "SELECT * FROM users WHERE id = :sessionId";
            $req = $this->conn->prepare($sql);
            $req->execute(array(':sessionId' => $sessionId));
            $row = $req->rowCount();

            if(password_verify($password,$passwordTrue)){

                if ($_SESSION['login'] != $login && strlen($login) >= 4 && !preg_match("[\W]", $login)){

                    if($row!=1){

                        $this->error = 'Error! The login already exist';

                    }else{

                        $sqlLog = "UPDATE utilisateurs SET login = :login WHERE id = :sessionId";
                
                        // Check if the username is already present or not in our Database.
                        $req = $this->conn->prepare($sqlLog);
                        $req->execute(array(':login' => $login, ':sessionId' => $sessionId));
                        
                        $_SESSION['login'] = $login;
                        $this->error = 'Success!Your login has been edited';

                    }

                }elseif(strlen($login) < 4 || preg_match("[\W]", $login)) {

                    $this->error = "Your login must contain at least 4 caracters and no specials caracters";

                }

                if (!empty($passwordNew) && !empty($passwordNewConfirm && $passwordNew == $passwordNewConfirm && strlen($passwordNew) >= 5)){

                    $hash = password_hash($passwordNew, PASSWORD_DEFAULT);

                    $sqlPass = "UPDATE utilisateurs SET password = '$hash' WHERE id = '$sessionId'";
                    $rs = $this->conn->query($sqlPass);

                    $_SESSION['password'] = $hash;
                    $this->error = 'Success! Your password has been edited';

                }elseif(strlen($passwordNew) < 5 and !empty($passwordNew)) {

                    $this->error = "Your password must contain at least 5 caracters";

                }elseif (!empty($passwordNew) && empty($passwordNewConfirm)){
        
                    $this->error = "Error! Please confirm password";
        
                }elseif(($passwordNew != $passwordNewConfirm)) {
    
                    $this->error = "Error! The passwords are differents";

                }

                if ($_SESSION['email'] != $email && preg_match("/@/", $email) && preg_match("/\./", $email)){

                    $sqlMail = "UPDATE utilisateurs SET email = '$email' WHERE id = '$sessionId'";
                    $rs = $this->conn->query($sqlMail);
                    $_SESSION['email'] = $email;
                    $this->error = 'Success! Your email has been edited';

                }elseif(!preg_match("/@/", $email) || !preg_match("/\./", $email)) {

                    $this->error = "Your email is not valid. It must contain '@' and '.'";

                }
                    
                
            }else{ $this->error = 'Error! Wrong password'; }

        }else{ $this->error = 'Error! Please login to change your infos '; }

        return $this->error ;

    }

    public function IsConnected() {

        if($_SESSION){
            return true;
        }else{
            return false;
        }

    }

    public function GetAllInfos() {

        if($_SESSION){
            return $_SESSION;
        }else{
            echo 'Please login to view your infos<br>';
        }

    }

    public function GetLogin() {

        if($_SESSION){
            return $_SESSION['login'];
        }else{
            echo 'Please login to view your login<br>';
        }

    }

    public function GetEmail() {

        if($_SESSION){
            return $_SESSION['email'];
        }else{
            echo 'Please login to view your email<br>';
        }
    }

}

$newUser = new User();


?>