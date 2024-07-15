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
        <?php
            require SRC_URL."front/navbar.php";
            require "post_search_form.php";
        ?>
        <section>
            <!-- Título -->
            <div class = "text-center">
                <h2>Postagens</h2>
            </div>
            <table class = "table-container">
                <thead>
                <th scope="col">ID</th>
                <th scope="col">ID Usuário</th>
                <th scope="col">Usuário</th>
                    <th scope="col">Texto</th>
                    <th scope="col">Data</th>
                    <th scope="col">Curtidas</th>
                    <th scope="col">Comentários</th>                                     
                    <th scope="col" colspan="2">Ações</th>
                </thead>
                <tbody>
                    <?php
                        /*
                        $db = db_conn();
                        $query = $db->query("SELECT * FROM post");
                        $posts = [];
                        while($row = $query->fetchArray(SQLITE3_ASSOC)){
                            $posts[] = $row;
                        }
                        */
                        if (isset($_SESSION['posts'])) {
                            //var_dump($_SESSION['posts']);
                            foreach ($_SESSION['posts'] as $post) {
                                $text = strlen($post['text']) >= 45 ? substr($post['text'],0,45)."..." : $post['text'];
                                echo "<tr scope = 'row' id = 'post-".$post['id']."' >";
                                echo "<td>".$post['id']."</td>";
                                echo "<td>".$post['id_user']."</td>";
                                echo "<td>".$post['username']."</td>";
                                echo "<td>$text</td>";
                                echo "<td>".time_ago($post['created_at'])."</td>";
                                echo "<td>".$post['total_likes']."</td>";
                                echo "<td>".$post['total_comments']."</td>";
                                echo "<td>
                                        <div class = 'btn-group' role = 'group' aria-labelledby = 'posts actions'>"
                                            .set_link_button('Ver','crud/view_post.php?id='.$post['id'],'btn btn-dark')
                                            .set_link_button($post['liked'] ? "Curtiu" : "Curtir",'like_post.php?id_post='.$post['id']."&redirect_url=".$_SERVER['REQUEST_URI'],$post['liked'] ? "btn btn-success" : "btn btn-primary").
                                        "</div>
                                    </td>";
                                echo "</tr>";
                            }
                            unset($_SESSION['posts']);
                        }
                    ?>
                </tbody>
            </table>
        </section>
        <?php require SRC_URL."front/footer.php"; ?>
    </body>
</html>