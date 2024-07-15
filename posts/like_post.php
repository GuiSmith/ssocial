<?php

    require "../src/back/config.php";
    require SRC_URL."back/functions.php";
    checkAuth(true);

    if (isset($_GET['id_post']) && is_natural($_GET['id_post'])) {
        $id_post = $_GET['id_post'];
        $redirect_url = isset($_GET['redirect_url']) ? $_GET['redirect_url'] : POSTS_LINK."posts.php";
        $db = db_conn();

        /*
        echo "<p>";
        echo "ID usuário: ".$_SESSION['user']['id'];
        echo "<br>";
        echo "ID Postagem: $id_post";
        echo "</p>";
        */

        if($db->querySingle("SELECT created_at FROM post_likes WHERE id_user = ".$_SESSION['user']['id']." AND id_post = $id_post") == null){
            $_SESSION['feedback']['like'] = "Você começou a seguir";
            $sql = "INSERT INTO post_likes (id_user,id_post) VALUES (:id_user,:id_post)";
        }else{
            $sql = "DELETE FROM post_likes WHERE id_user = :id_user AND id_post = :id_post";
            $_SESSION['feedback']['like'] = "Você deixou de seguir";
        }

        $query = $db->prepare($sql);
        $query->bindValue(':id_user',$_SESSION['user']['id'],SQLITE3_INTEGER);
        $query->bindValue(':id_post',$id_post,SQLITE3_INTEGER);
        if ($query->execute()) {
            header("Location: $redirect_url#post-$id_post");
        }else{
            echo $db->lastErrorMsg();
        }
        
    }else{
        //header("Location: ".POSTS_LINK."posts.php");
    }

?>