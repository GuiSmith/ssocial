<?php

    require '../../src/back/config.php';
    checkAuth(true);
    if(isset($_GET['id']) && is_natural($_GET['id'])){
        require SRC_URL."back/functions.php";
        $id = get_input($_GET['id']);
        $db = db_conn();
        $id_user = $db->querySingle("SELECT id_user FROM posts WHERE id = $id");
        if ($id_user == $_SESSION['user']['id']) {
            $db->exec("DELETE FROM posts WHERE id = $id");
            $href = POSTS_LINK."posts.php";
        }else{
            $href = POSTS_LINK."crud/view_post.php?id=$id";
        }
    }else{
        $href = POSTS_LINK."crud/view_post.php?id=$id";
    }
    header("Location: $href");
?>