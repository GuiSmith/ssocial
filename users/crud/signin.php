<?php

    require "../../src/back/config.php";
    checkAuth(false);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require SRC_URL."front/head.php" ?>
    </head>
    <body>
        <?php require SRC_URL."front/navbar.php" ?>
        <form class = "container form-container" action="set_user.php" method = "POST" autocomplete = "off">
            <!-- Título -->
            <div class = "text-center">
                <h2>Registro de conta</h2>
            </div>
            <!-- Name -->
            <div class = "form-group">
                <label for="username-input" class = "form-label">Nome</label>
                <input type="text" id = "username-input" name = "username" class = "form-control" value = "<?php echo isset($_SESSION['signin']["username"]) ? $_SESSION['signin']["username"] : "" ?>" required>
                <small class = "form-text text-danger">
                    <?php echo (isset($_SESSION['feedback']['signin']['username'])) ? $_SESSION['feedback']['signin']['username'] : ""; ?>
                </small>
            </div>
            <!-- E-mail -->
            <div class = "form-group">
                <label for="email-input" class = "form-label">E-mail</label>
                <input type="email" id = "email-input" name = "email" class = "form-control" value = "<?php echo isset($_SESSION['signin']["email"]) ? $_SESSION['signin']["email"] : "" ?>" required>
                <small class = "form-text text-danger">
                    <?php echo (isset($_SESSION['feedback']['signin']['email'])) ? $_SESSION['feedback']['signin']['email'] : ""; ?>
                </small>
            </div>
            <!-- CPF -->
            <div class = "form-group">
                <label for="cpf-input" class = "form-label">CPF</label>
                <input type="text" id = "cpf-input" name = "cpf" class = "form-control" value = "<?php echo isset($_SESSION['signin']["cpf"]) ? $_SESSION['signin']["cpf"] : "" ?>" required>
                <small class = "form-text text-danger">
                    <?php echo (isset($_SESSION['feedback']['signin']['cpf'])) ? $_SESSION['feedback']['signin']['cpf'] : ""; ?>
                </small>
            </div>
            <!-- Senha -->
            <div class = "form-group">
                <label for="pass-input" class = "form-label">Senha</label>
                <input type="password" id = "pass-input" name = "pass" class = "form-control" value = "<?php echo isset($_SESSION['signin']["pass"]) ? $_SESSION['signin']["pass"] : "" ?>" required>
                <small class = "form-text text-danger">
                    <?php echo isset($_SESSION['feedback']['signin']['pass']) ? $_SESSION['feedback']['signin']['pass'] : ""; ?>
                </small>
            </div>
            <!-- Enviar -->
            <div style = "text-align: right" >
                <button type = "submit" class = "btn btn-success">Registrar</button>    
            </div>
            <small class = "form-text text-muted" >
                Já tem uma conta? 
                <a href = "<?php echo AUTH_LINK ?>login.php">Entrar</a>
            </small>
        </form>
        <?php //require_source("front/script.php") ?>
    </body>
</html>