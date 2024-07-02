<?php

    require "../src/back/config.php";
    checkAuth(false);
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $db = db_conn();
        require SRC_URL."back/functions.php";

        $_SESSION['signin']['username'] = $username = get_chars(get_input($_POST['username']));
        $_SESSION['signin']['email'] = $email = get_input($_POST['email']);
        $_SESSION['signin']['cpf'] = $cpf = getCPF(get_input($_POST['cpf']));
        $_SESSION['signin']['pass'] = $pass = get_input($_POST['pass']);
        $ok = true;
        $href = AUTH_LINK."signin.php";
        
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
        //Password
        if (empty($pass)) {
            $_SESSION['feedback']['pass'] = "É preciso preencher a senha";
            $ok = false;
        }else{
            unset($_SESSION['feedback']['pass']);
        }

        if ($ok) {
            $in_SQL = "INSERT OR ROLLBACK INTO users (username,email,pass,cpf) values (:username,:email,:pass,:cpf)";
            $in_query = $db->prepare($in_SQL);
            $in_query->bindValue(':username',$username,SQLITE3_TEXT);
            $in_query->bindValue(':email',$email,SQLITE3_TEXT);
            $pass = password_hash($pass,PASSWORD_DEFAULT);
            $in_query->bindValue(':pass',$pass,SQLITE3_TEXT);
            $in_query->bindValue(':cpf',$cpf,SQLITE3_TEXT);

            try {
                if ($in_query->execute()) {
                    unset($_SESSION['feedback']);
                    unset($_SESSION['signin']);
                    $href = AUTH_LINK."login.php";
                }else{
                    // Check the last error code and message
                    $error_code = $db->lastErrorCode();
                    $error_message = $db->lastErrorMsg();
                    $error = get_violation_message($db->lastErrorCode(),$db->lastErrorMsg());
                    $_SESSION['feedback'][$error['column']] = $error['message'];
                }
            } catch (SQLite3Exception $error) {
                var_dump($error);
                echo "exception";
                //var_dump($error);
            } catch (Exception $error) {
                var_dump($error);
            }
        }
        header("Location: $href");
    }else{
        echo "Você não devia estar aqui.";
        echo "<a href = '".MAIN_LINK."index.php'>Voltar</a>";
    }

?>