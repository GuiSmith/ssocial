<?php

    require "../src/back/config.php";
    checkAuth(true,true);

    $routine_feedback = "";

    $totals = [
        'total_posts_likes_given' => 'Atualizar total de curtidas dadas',
        'total_posts_likes_received' => 'Atualizar total de curtidas recebidas',
        'total_likes_per_post' => 'Atualizar total de curtidas por post',
        'total_posts' => 'Atualizar total de posts',
        'total_followers' => 'Atualizar total de seguidores',
        'total_following' => 'Atualizar total de seguindo',
        'total_visits_made' => 'Atualizar total de visitas feitas',
        'total_visits_received' => 'Atualizar total de visitas recebidas'
    ];

    if (isset($_GET['routine'])) {
        $routine = $_GET['routine'];

        switch ($routine) {
            case 'total_posts_likes_given':
                $sql = "UPDATE users_statistics 
                        SET total_posts_likes_given = (
                            SELECT COUNT(*) 
                            FROM post_likes 
                            WHERE post_likes.id_user = users_statistics.id_user
                        )";
                break;

            case 'total_posts_likes_received':
                $sql = "UPDATE users_statistics 
                        SET total_posts_likes_received = (
                            SELECT COUNT(*) 
                            FROM post_likes 
                            JOIN posts ON post_likes.id_post = posts.id 
                            WHERE posts.id_user = users_statistics.id_user
                        )";
                break;

            case 'total_likes_per_post':
                $sql = "UPDATE posts 
                        SET total_likes = (
                            SELECT COUNT(*) 
                            FROM post_likes 
                            WHERE post_likes.id_post = posts.id
                        )";
                break;

            case 'total_posts':
                $sql = "UPDATE users_statistics 
                        SET total_posts = (
                            SELECT COUNT(*) 
                            FROM posts 
                            WHERE posts.id_user = users_statistics.id_user
                        )";
                break;

            case 'total_followers':
                $sql = "UPDATE users_statistics 
                        SET total_followers = (
                            SELECT COUNT(*) 
                            FROM users_follow 
                            WHERE users_follow.id_user_followed = users_statistics.id_user
                        )";
                break;

            case 'total_following':
                $sql = "UPDATE users_statistics 
                        SET total_following = (
                            SELECT COUNT(*) 
                            FROM users_follow 
                            WHERE users_follow.id_user_follower = users_statistics.id_user
                        )";
                break;

            case 'total_visits_made':
                $sql = "UPDATE users_statistics 
                        SET total_visits_made = (
                            SELECT COUNT(*) 
                            FROM users_visits 
                            WHERE users_visits.id_guest = users_statistics.id_user
                        )";
                break;

            case 'total_visits_received':
                $sql = "UPDATE users_statistics 
                        SET total_visits_received = (
                            SELECT COUNT(*) 
                            FROM users_visits 
                            WHERE users_visits.id_host = users_statistics.id_user
                        )";
                break;

            default:
                // Se nenhum case correspondente for encontrado
                $routine_feedback = "Rotina não reconhecida";
                break;
        }

        // Se o SQL foi definido, prepara e executa a consulta
        if (isset($sql)) {
            try {
                $db = db_conn();
                $up_query = $db->prepare($sql);
                $up_query->execute();
                $routine_feedback = "Rotina <code>".$totals[$routine]."</code> foi executada com sucesso";
            } catch (PDOException $e) {
                // Em caso de erro na execução da consulta SQL
                $routine_feedback = "Erro ao executar rotina $routine: " . $e->getMessage();
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require SRC_URL."/front/head.php" ?>
    </head>
    <body>
        <?php require SRC_URL."/front/navbar.php" ?>
        
        <section>
            <div class = "text-center">
                <h1>Rotinas</h1>
                <h3>Atualizar totais</h3>
            </div>
            <div class = "container">
                <div class = "input-group">
                <?php
                    $class = "btn btn-outline-dark";

                    foreach ($totals as $type => $label) {
                        echo set_link_button($label, "routines.php?routine=$type", $class);
                    }
                ?>
                </div>
                <h3 class = 'text-center' >
                    <?php echo !empty($routine_feedback) ? $routine_feedback : "" ?>
                </h3>
            </div>
        </section>
    </body>
</html>