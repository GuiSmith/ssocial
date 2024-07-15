<?php

    require "../../src/back/config.php";
    checkAuth(true);

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        require SRC_URL."back/functions.php";
        $_SESSION['post']['id'] = $id = get_input($_POST['id']);
        $_SESSION['post']['text'] = $text = get_input($_POST['text']);
        $ok = true;
        $href = POSTS_URL."crud/edit_post.php?id=$id";

        if (empty($text)) {
            $_SESSION['feedback']['post']['text'] = "Informe um texto!";
            $ok = false;
        }else{
            unset($_SESSION['feedback']['post']['text']);
        }

        if ($ok) {
            $db = db_conn();
            $insert_query = $db->prepare("UPDATE posts SET text = :text WHERE id = :id");
            $insert_query->bindValue(":id",$id,SQLITE3_INTEGER);
            $insert_query->bindValue(":text",$text,SQLITE3_TEXT);
            if ($insert_query->execute()) {
                unset($_SESSION['feedback']['post']);
                unset($_SESSION['post']);
                $last_id = $db->lastInsertRowID();
                $href = "view_post.php?id=".$id;
            }else{
                $_SESSION['feedback']['post']['general'] = "Houve um erro com a inserção da postagem".$db->lastErrorMsg();
            }
        }
        header("Location: $href");
    }
?>