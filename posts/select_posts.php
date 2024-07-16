<?php

    if ($_SERVER["REQUEST_METHOD"] == "POST" || isset($_GET['all']) && $_GET['all']) {
        require "../src/back/config.php";
        require SRC_URL."back/functions.php";
        $db = db_conn();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $_SESSION['select']['posts']['id'] = $id = get_input($_POST['id']);
            $_SESSION['select']['posts']['id_user'] = $id_user = get_input($_POST['id_user']);            
            $_SESSION['select']['posts']['username'] = $username = get_input($_POST['username']);
            $_SESSION['select']['posts']['text'] = $text = get_input($_POST['text']);
            $redirect_url = $_POST['redirect_url'];
        }else{
            $_SESSION['select']['posts']['id'] = $id = "";
            $_SESSION['select']['posts']['id_user'] = $id_user = "";
            $_SESSION['select']['posts']['username'] = $username = "";
            $_SESSION['select']['posts']['text'] = $text = "";
            $redirect_url = isset($_GET['redirect_url']) ? $_GET['redirect_url'] : POSTS_URL."posts.php";
        }
        $cols = [];

        foreach ($_SESSION['select']['posts'] as $col => $value) {
            if (!empty($value)) {
                $cols[$col] = $value;
            }
        }

        $posts = get_posts($cols);

        if ($posts && !empty($posts)) {
            $_SESSION['posts'] = $posts;
            unset($_SESSION['feedback']['select']);
        }else{
            $_SESSION['feedback']['select']['posts']['text'] = "Nenhum post se enquadra nos parâmetros";
        }
        /*
        echo "<br><br>Dados: ";
        var_dump($_SESSION['select']['posts']);
        echo "<br><br>Colunas: ";
        var_dump($cols);
        echo "<br><br>Usuários: ";
        var_dump($posts);
        echo "<br><br>Feedback: ";
        if(isset($_SESSION['feedback']['select']['posts']['text'])) var_dump($_SESSION['feedback']['select']['posts']['text']);
        */
        header("Location: $redirect_url");
    }

?>