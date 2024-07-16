<?php

    require "../src/back/config.php";
    if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {
        $id = $_GET['id'];
    }else{
        checkAuth(true);
        $id = $_SESSION['user']['id'];
    }
    $db = db_conn();
    $sql = "SELECT * FROM user_statistics WHERE ID = $id";
    $query = $db->query($sql);
    $statistic = $query->fetchArray(SQLITE3_ASSOC);
    
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require SRC_URL."front/head.php" ?>
    </head>
    <body>
        <?php require SRC_URL."front/navbar.php" ?>
        <!-- Título -->
        <div class = "text-center">
            <h2>Estatísticas de <?php echo explode(" ",$statistic['Nome'])[0] ?></h2>
        </div>
        <form class = "container form-container" action="follow_user.php" method="POST" autocomplete = 'off'  >
            <?php
                foreach ($statistic as $key => $value) {
                    echo set_form_input($key,$key,$value,['disabled' => true]);
                }
            ?>
        </form>
        <?php require SRC_URL."front/script.php" ?>
    </body>
</html>