<?php

    require "../../src/back/config.php";
    checkAuth(true);

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        require SRC_URL."back/functions.php";
        $_SESSION['post']['text'] = $text = get_input($_POST['text']);
        $ok = true;
        $href = POSTS_URL."crud/post.php";

        if (empty($text)) {
            $_SESSION['feedback']['post']['text'] = "Informe um texto!";
            $ok = false;
        }else{
            unset($_SESSION['feedback']['post']['text']);
        }

        if ($ok) {
            $db = db_conn();
            $insert_query = $db->prepare("INSERT INTO posts (id_user,text) VALUES (:id_user,:text)");
            $insert_query->bindValue(":id_user",$_SESSION['user']['id'],SQLITE3_INTEGER);
            $insert_query->bindValue(":text",$text,SQLITE3_TEXT);
            if ($insert_query->execute()) {
                unset($_SESSION['feedback']['post']);
                unset($_SESSION['post']);
                $last_id = $db->lastInsertRowID();
                $href = "view_post.php?id=".$last_id;
            }else{
                $_SESSION['feedback']['post']['general'] = "Houve um erro com a inserção da postagem".$db->lastErrorMsg();
            }
            var_dump($last_id);
        }
        var_dump($_FILES['image_src']);
        var_dump($_POST['caption']);
        //header("Location: $href");
    }
?>