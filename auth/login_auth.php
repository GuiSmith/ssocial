<?php

    require "../src/back/config.php";
    checkAuth(false);

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $db = db_conn();
        require SRC_URL."back/functions.php";

        $_SESSION['login']['email'] = $email = get_input($_POST['email']);
        $_SESSION['login']['pass'] = $pass = get_input($_POST['pass']);
        
        //E-mail
        if(empty($email)){
            $_SESSION['feedback']['email'] = "Informe o e-mail!";
        }else{
            unset($_SESSION['feedback']['email']);
        }
        //Password
        if(empty($pass)){
            $_SESSION['feedback']['pass'] = "Informe a senha!";
        }else{
            unset($_SESSION['feedback']['email']);
        }

        $user = get_user_by('email',$email);

        if ($user) {
            if (password_verify($pass,$user['pass'])) {
                $_SESSION["user"] = $user;
                $_SESSION["logged"] = true;
            }else{
                $_SESSION['feedback']['pass'] = "Senha incorreta!";
            }
        }else{
            $_SESSION['feedback']['email'] = "E-mail não encontrado";
        }
        header("Location: ".AUTH_LINK."login.php");
    }

?>