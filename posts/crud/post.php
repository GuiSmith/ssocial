<?php

    require "../../src/back/config.php";
    checkAuth(true);

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require SRC_URL."front/head.php" ?>
    </head>
    <body>
        <?php require SRC_URL."front/navbar.php" ?>
        <form class = "container form-container" action="set_post.php" method = "POST" autocomplete = "off">
            <!-- Título -->
            <div class = "text-center">
                <h2>Nova postagem</h2>
            </div>
            <!-- Add Image Icon -->
            <button type="button" class="btn btn-outline-primary">
                <i class="fas fa-image"></i> Add Image
            </button>
            <!-- Text -->
            <div class = "form-group">
                <label for="text-input" class = "form-label">Texto</label>
                <textarea name="text" id="text-input" cols="30" rows="3" class = "form-control" maxlength = "100" oninput = "limitLength(100,'text-feedback')" required ><?php echo isset($_SESSION['feedback']['post']["text"]) ? $_SESSION['feedback']['post']['text'] : "" ?></textarea>
                <small id = "text-feedback" class = "form-text text-muted" style="display: block;text-align: right">
                    100
                </small>
            </div>
            <!-- Enviar -->
            <div style = "text-align: right" >
                <button type = "submit" class = "btn btn-primary">Postar</button>    
            </div>
        </form>
        <?php require SRC_URL."front/script.php" ?>
    </body>
</html>