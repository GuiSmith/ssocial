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
        <!-- Form -->
        <form class = "container form-container" action="login_auth.php" method = "POST" autocomplete = "off">
            <h3 class = "text-center">Entrar</h3>
            <!-- E-mail -->
            <div class = "form-group">
                <label for="email-input" class = "form-label">E-mail</label>
                <input type="email" id = "email-input" name = "email" class = "form-control" value = "<?php echo isset($_SESSION['login']["email"]) ? $_SESSION['login']["email"] : "" ?>" required>
                <small class = "form-text text-danger">
                    <?php echo (isset($_SESSION['feedback']['login']['login']['email'])) ? $_SESSION['feedback']['login']['email'] : ""; ?>
                </small>
            </div>
            <!-- Senha -->
            <div class = "form-group">
                <label for="pass-input" class = "form-label">Senha</label>
                <input type="password" id = "pass-input" name = "pass" class = "form-control" value = "<?php echo isset($_SESSION['login']["pass"]) ? $_SESSION['login']["pass"] : "" ?>" required>
                <small class = "form-text text-danger">
                    <?php echo (isset($_SESSION['feedback']['login']['pass'])) ? $_SESSION['feedback']['login']['pass'] : ""; ?>
                </small>
            </div>
            <!-- Enviar -->
            <div style = "text-align: right" >
                <button type = "submit" class = "btn btn-success">Entrar</button>    
            </div>
            <small class = "form-text text-muted" >
                <a href = "<?php echo AUTH_LINK ?>signin.php">Criar conta</a>
            </small>
        </form>
    </body>
</html>