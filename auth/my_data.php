<?php

    require "../src/back/config.php";
    checkAuth(true);
    
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require SRC_URL."front/head.php" ?>
    </head>
    <body>
        <?php require SRC_URL."front/navbar.php" ?>
        <form class = "container form-container" action="update_user.php" method = "POST" autocomplete = "off">
            <!-- Título -->
            <div class = "text-center">
                <h2>Dados de <?php echo $_SESSION['user']['username'] ?></h2>
            </div>
            <!-- Name -->
            <div class = "form-group">
                <label for="username-input" class = "form-label">Nome</label>
                <input type="text" id = "username-input" name = "username" class = "form-control" value = "<?php echo isset($_SESSION['update']["username"]) ? $_SESSION['update']["username"] : $_SESSION['user']['username'] ?>" required>
                <small class = "form-text text-danger">
                    <?php echo (isset($_SESSION['feedback']['username'])) ? $_SESSION['feedback']['username'] : ""; ?>
                </small>
            </div>
            <!-- E-mail -->
            <div class = "form-group">
                <label for="email-input" class = "form-label">E-mail</label>
                <input type="email" id = "email-input" name = "email" class = "form-control" value = "<?php echo isset($_SESSION['update']["email"]) ? $_SESSION['update']["email"] : $_SESSION['user']['email'] ?>" required>
                <small class = "form-text text-danger">
                    <?php echo (isset($_SESSION['feedback']['email'])) ? $_SESSION['feedback']['email'] : ""; ?>
                </small>
            </div>
            <!-- CPF -->
            <div class = "form-group">
                <label for="cpf-input" class = "form-label">CPF</label>
                <input type="text" id = "cpf-input" name = "cpf" class = "form-control" value = "<?php echo isset($_SESSION['update']["cpf"]) ? $_SESSION['update']["cpf"] : $_SESSION['user']['cpf'] ?>" required>
                <small class = "form-text text-danger">
                    <?php echo (isset($_SESSION['feedback']['cpf'])) ? $_SESSION['feedback']['cpf'] : "" ?>
                </small>
            </div>
            <!-- Senha -->
            <div class = "form-group">
                <label for="pass-input" class = "form-label">Senha</label>
                <input type="password" id = "pass-input" name = "pass" class = "form-control" value = "<?php echo isset($_SESSION['update']["pass"]) ? $_SESSION['update']["pass"] : "" ?>" >
                <small class = "form-text text-muted" >
                    Deixe o campo vazio para não atualizar a senha
                </small>
                <br>
                <small class = "form-text text-danger">
                    <?php echo (isset($_SESSION['feedback']['pass'])) ? $_SESSION['feedback']['pass'] : "" ?>
                </small>
            </div>
            <!-- Enviar -->
            <div class = "row" >
                <div class = "col-lg-6 col-md-6 col-sm-12" style = "text-align: left">
                    <a class = "btn btn-danger" href="delete_user.php?id=<?php echo $_SESSION['user']['id'] ?>">Deletar</a>
                </div>
                <div class = "col-lg-6 col-md-6 col-sm-12" style = "text-align: right">
                    <button type = "submit" class = "btn btn-success">Salvar</button>
                </div>
            </div>
        </form>
        <?php //require_source("front/script.php") ?>
    </body>
</html>