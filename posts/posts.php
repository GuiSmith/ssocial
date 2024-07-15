<?php

    require "../src/back/config.php";
    if(!isset($_SESSION['posts'])){
        header("Location: select_posts.php?all=true&redirect_url=".$_SERVER['REQUEST_URI']);
        //Somehow submit the form so all posts can appear
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require SRC_URL."front/head.php" ?>
    </head>
    <body>
        <?php require SRC_URL."front/navbar.php" ?>
        <?php require "post_search_form.php" ?>
        <section>
            <!-- Título -->
            <div class = "text-center">
                <h2>Postagens</h2>
            </div>
            <!-- Postagens -->
            <?php
                if (isset($_SESSION['posts'])) {
                    foreach ($_SESSION['posts'] as $post) {
                        echo set_post_form($post);
                    }
                    unset($_SESSION['posts']);
                }
            ?>
        </section>
        <?php require SRC_URL."front/footer.php" ?>
    </body>
</html>
