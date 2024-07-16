<?php

    require "../../src/back/config.php";

    if (isset($_GET['id']) && is_natural($_GET['id'])) {
        $id = $_GET['id'];
        $cols = ['id' => $id];
        $post = get_posts($cols,true);
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
        <?php echo set_post_form($post) ?>
        <?php require SRC_URL."front/script.php" ?>
    </body>
</html>
