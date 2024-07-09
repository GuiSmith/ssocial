<?php

    require "../../src/back/config.php";
    checkAuth(true);
    $db = db_conn();
    $result = $db->query('SELECT * FROM my_data WHERE id = '.$_SESSION['user']['id']);
    $my_data = $result->fetchArray(SQLITE3_ASSOC);
    
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
                <h2>Dados de <?php echo $my_data['username'] ?></h2>
            </div>
            <!-- Name -->
            <div class = "form-group">
                <label for="username-input" class = "form-label">Nome</label>
                <input type="text" id = "username-input" name = "username" class = "form-control" value = "<?php echo isset($_SESSION['update']["username"]) ? $_SESSION['update']["username"] : $my_data['username'] ?>" required>
                <small class = "form-text text-danger">
                    <?php echo (isset($_SESSION['feedback']['username'])) ? $_SESSION['feedback']['username'] : ""; ?>
                </small>
            </div>
            <!-- E-mail -->
            <div class = "form-group">
                <label for="email-input" class = "form-label">E-mail</label>
                <input type="email" id = "email-input" name = "email" class = "form-control" value = "<?php echo isset($_SESSION['update']["email"]) ? $_SESSION['update']["email"] : $my_data['email'] ?>" required>
                <small class = "form-text text-danger">
                    <?php echo (isset($_SESSION['feedback']['email'])) ? $_SESSION['feedback']['email'] : ""; ?>
                </small>
            </div>
            <!-- CPF -->
            <div class = "form-group">
                <label for="cpf-input" class = "form-label">CPF</label>
                <input type="text" id = "cpf-input" name = "cpf" class = "form-control" value = "<?php echo isset($_SESSION['update']["cpf"]) ? $_SESSION['update']["cpf"] : $my_data['cpf'] ?>" required>
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
            <!-- Bio -->
            <div class = "form-group">
                <label for="bio-input" class = "form-label">Biografia</label>
                <textarea name="bio" id="bio-input" cols="30" rows="3" class = "form-control" maxlength = "100" oninput = "limitLength(100,'bio-feedback')" ><?php echo isset($_SESSION['update']["bio"]) ? $_SESSION['update']['bio'] : $my_data['bio'] ?></textarea>
                <small id = "bio-feedback" class = "form-text text-muted" style="display: block;text-align: right">
                    100
                </small>
                <br>
            </div>
            <!-- Enviar -->
            <div class = "row" >
                <div class = "col-lg-3 col-md-4 col-sm-12" style = "text-align: left">
                    <a class = "btn btn-danger" href="delete_user.php?id=<?php echo $my_data['id'] ?>">Deletar</a>
                </div>
                <div class = "col-lg-6 col-md-4 col-sm-12" style = "text-align: center">
                    <small class = "form-text text-success" >
                        <?php echo isset($_SESSION['feedback']['update']) ? $_SESSION['feedback']['update'] : "" ?>
                    </small>
                </div>
                <div class = "col-lg-3 col-md-4 col-sm-12" style = "text-align: right">
                    <button type = "submit" class = "btn btn-success">Salvar</button>
                </div>
            </div>
        </form>
        <?php require SRC_URL."front/script.php" ?>
        <script>

        </script>
    </body>
</html>