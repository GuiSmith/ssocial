<?php

    require "../../src/back/config.php";
    checkAuth(false);
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $db = db_conn();
        require SRC_URL."back/functions.php";

        $_SESSION['signin']['username'] = $username = get_chars(get_input($_POST['username']));
        $_SESSION['signin']['email'] = $email = get_input($_POST['email']);
        $_SESSION['signin']['cpf'] = $cpf = getCPF(get_input($_POST['cpf']));
        $_SESSION['signin']['pass'] = $pass = get_input($_POST['pass']);
        $ok = true;
        $href = USERS_LINK."crud/signin.php";
        
        //Username
        if (empty($username)) {
            $_SESSION['feedback']['signin']['username'] = "É preciso preencher o nome";
            $ok = false;
        }else{  
            unset($_SESSION['feedback']['signin']['username']);
        }
        //E-mail
        if (empty($email)) {
            $_SESSION['feedback']['signin']['email'] = "É preciso preencher o e-mail!";
            $ok = false;
        }else{
            if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
                $_SESSION['feedback']['signin']['email'] = "E-mail inválido";
            }else{
                unset($_SESSION['feedback']['signin']['email']);
            }
        }
        //CPF
        if (!checkCPF($cpf)) {
            $_SESSION['feedback']['signin']['cpf'] = "CPF inválido";
            $ok = false;
        }else{
            unset($_SESSION['feedback']['signin']['cpf']);
        }
        //Password
        if (empty($pass)) {
            $_SESSION['feedback']['signin']['pass'] = "É preciso preencher a senha";
            $ok = false;
        }else{
            unset($_SESSION['feedback']['signin']['pass']);
        }

        if ($ok) {
            $in_SQL = "INSERT OR ROLLBACK INTO users (username,email,pass,cpf) values (:username,:email,:pass,:cpf)";
            $in_query = $db->prepare($in_SQL);
            $in_query->bindValue(':username',$username,SQLITE3_TEXT);
            $in_query->bindValue(':email',$email,SQLITE3_TEXT);
            $pass = password_hash($pass,PASSWORD_DEFAULT);
            $in_query->bindValue(':pass',$pass,SQLITE3_TEXT);
            $in_query->bindValue(':cpf',$cpf,SQLITE3_TEXT);

            if ($in_query->execute()) {
                unset($_SESSION['feedback']['signin']);
                unset($_SESSION['signin']);
                $href = USERS_LINK."auth/login.php";
            }else{
                $_SESSION['feedback']['signin']['pass'] = "Houve um erro na criação de um usuário: ".$db->lastErrorMsg();
            }
        }
        header("Location: $href");
    }else{
        echo "Você não devia estar aqui.";
        echo "<a href = '".MAIN_LINK."index.php'>Voltar</a>";
    }

?>