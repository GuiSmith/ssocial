<?php

    require "../../src/back/config.php";
    checkAuth(false);

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $db = db_conn();
        require SRC_URL."back/functions.php";

        $_SESSION['login']['email'] = $email = get_input($_POST['email']);
        $_SESSION['login']['pass'] = $pass = get_input($_POST['pass']);
        
        //E-mail
        if(empty($email)){
            $_SESSION['feedback']['login']['email'] = "Informe o e-mail!";
        }else{
            unset($_SESSION['feedback']['login']['email']);
        }
        //Password
        if(empty($pass)){
            $_SESSION['feedback']['login']['pass'] = "Informe a senha!";
        }else{
            unset($_SESSION['feedback']['login']['email']);
        }

        $user = get_user_by('email',$email);

        if ($user) {
            if (password_verify($pass,$user['pass'])) {
                $_SESSION["user"] = [
                    'id' => $user['id'],
                    'adm' => $user['adm']
                ];
                $db->exec("UPDATE users SET logged_at = CURRENT_TIMESTAMP WHERE id = ".$user['id']);
            }else{
                $_SESSION['feedback']['login']['pass'] = "Senha incorreta!";
            }
        }else{
            $_SESSION['feedback']['login']['email'] = "E-mail não encontrado";
        }
        header("Location: ".USERS_LINK."auth/login.php");
    }

?>