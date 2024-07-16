<?php

    require "../../src/back/config.php";
    checkAuth(true);

    if (isset($_GET['id']) && is_natural($_GET['id'])) {
        $id = $_GET['id'];
        $db = db_conn();
        $query = $db->query("SELECT * FROM post WHERE id = $id AND id_user = ".$_SESSION['user']['id']);
        $post = $query->fetchArray(SQLITE3_ASSOC);
        if (!$post) header("Location: ".POSTS_LINK."posts.php");
        //var_dump($post);
    }else{
        header("Location: post.php");
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require SRC_URL."front/head.php" ?>
    </head>
    <body>
        <?php require SRC_URL."front/navbar.php" ?>
        <form class = "container form-container" action="update_post.php" method = "POST" autocomplete = "off">
            <!-- Título -->
            <div class = "text-center">
                <h2>Editando postagem</h2>
            </div>
            <?php echo set_form_input('ID','id',$post['id'],['readonly' => true]) ?>
            <!-- Text -->
            <div class = "form-group">
                <label for="text-input" class = "form-label">Texto</label>
                <textarea name="text" id="text-input" cols="30" rows="3" class = "form-control" maxlength = "100" oninput = "limitLength(100,'text-feedback')" required ><?php echo isset($_SESSION['feedback']['post']["text"]) ? $_SESSION['feedback']['post']['text'] : $post['text'] ?></textarea>
                <small id = "text-feedback" class = "form-text text-muted" style="display: block;text-align: right">
                    <?php echo 100-strlen($post['text']) ?>
                </small>
            </div>
            <!-- Enviar -->
            <div style = "text-align: right" >
                <button type = "submit" class = "btn btn-primary">Salvar</button>    
            </div>
        </form>
        <?php require SRC_URL."front/script.php" ?>
    </body>
</html>