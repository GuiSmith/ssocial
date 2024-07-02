<?php

    require "../src/back/config.php";
    checkAuth(true);
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $db = db_conn();
        require SRC_URL."back/functions.php";

        $_SESSION['update']['username'] = $username = get_input($_POST['username']);
        $_SESSION['update']['email'] = $email = get_input($_POST['email']);
        $_SESSION['update']['pass'] = $pass = !empty($_POST['pass']) ? password_hash(get_input($_POST['pass']),PASSWORD_DEFAULT) : "";
        $_SESSION['update']['pass'] = $cpf = getCPF(get_input($_POST['cpf']));
        $ok = true;
        
        //Username
        if (empty($username)) {
            $_SESSION['feedback']['username'] = "É preciso preencher o nome";
            $ok = false;
        }else{
            unset($_SESSION['feedback']['username']);
        }
        //E-mail
        if (empty($email)) {
            $_SESSION['feedback']['email'] = "É preciso preencher o e-mail!";
            $ok = false;
        }else{
            if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
                $_SESSION['feedback']['email'] = "E-mail inválido";
            }else{
                unset($_SESSION['feedback']['email']);
            }
        }
        //CPF
        if (!checkCPF($cpf)) {
            $_SESSION['feedback']['cpf'] = "CPF inválido";
            $ok = false;
        }else{
            unset($_SESSION['feedback']['cpf']);
        }

        if ($ok) {

            $up_SQL = "UPDATE users SET username = :username, email = :email, cpf = :cpf";
            if (!empty($pass)) $up_SQL .= ", pass = :pass";
            $up_SQL .= " WHERE id = :id";
            //var_dump($up_SQL);
            $up_query = $db->prepare($up_SQL);
            $up_query->bindValue(':username',$username,SQLITE3_TEXT);
            $up_query->bindValue(':email',$email,SQLITE3_TEXT);
            if (!empty($pass)) $up_query->bindValue(':pass',$pass,SQLITE3_TEXT);
            $up_query->bindValue(':cpf',$cpf,SQLITE3_TEXT);
            $up_query->bindValue(':id',$_SESSION['user']['id'],SQLITE3_INTEGER);        

            if ($up_query->execute()) {
                unset($_SESSION['feedback']);
                unset($_SESSION['update']);
                $_SESSION['user'] = get_user_by('id',$_SESSION['user']['id']);
            }else{
                // Check the last error code and message
                $error_code = $db->lastErrorCode();
                $error_message = $db->lastErrorMsg();
                $error = get_violation_message($db->lastErrorCode(),$db->lastErrorMsg());
                $_SESSION['feedback'][$error['column']] = $error['message'];
            }
        }

        header("Location: ".AUTH_LINK."my_data.php");
    }else{
        echo "Você não devia estar aqui.";
        echo "<a href = '".MAIN_LINK."index.php'>Voltar</a>";
    }

?>