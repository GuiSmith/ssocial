<?php

    require "../src/back/config.php";
    checkAuth(true);

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $db = db_conn();
        require SRC_URL."back/functions.php";

        $id_user_follower = $_SESSION['user']['id'];
        $id_user_followed = get_input($_POST['id']);
        
        echo "<p>";
            echo "ID usuário seguidor: $id_user_follower";
            echo "<br>ID usuário seguido: ".$id_user_followed;
        echo "</p>";
        

        $se_query = $db->query("SELECT * FROM users_follow WHERE id_user_follower = $id_user_follower AND id_user_followed = $id_user_followed");
        $user_follow = $se_query->fetchArray(SQLITE3_ASSOC);
        var_dump($user_follow);

        if ($user_follow) {
            $active = $user_follow['active'] ? 0 : 1;
            echo "<p>Novo status será: $active</p>";

            $up_query = $db->exec("UPDATE users_follow SET active = $active WHERE id_user_follower = $id_user_follower AND id_user_followed = $id_user_followed");
            if (!$up_query){
                $_SESSION['feedback']['follow'] = "Houve um erro ao atualizar status de seguir";
            }else{
                echo "<p>Atualizado com sucesso</p>";
            }
        }else{
            $in_query = $db->exec("INSERT INTO users_follow (id_user_follower,id_user_followed) VALUES ($id_user_follower,$id_user_followed)");
            if (!$in_query){
                $_SESSION['feedback']['follow'] = "Houve um erro ao seguir usuário";
            }else{
                echo "<p>Inserido com sucesso</p>";
            }
        }

        header("Location: ".USERS_LINK."profile.php?id=$id_user_followed");
    }

?>