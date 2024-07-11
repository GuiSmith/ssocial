<?php

    require "../src/back/config.php";
    if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {
        $id = $_GET['id'];
    }else{
        checkAuth(true);
        $id = $_SESSION['user']['id'];
    }
    $db = db_conn();
    $sql = "SELECT * FROM users LEFT JOIN users_statistics ON users.id = users_statistics.id_user WHERE users.id = $id";
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
        <form class = "container form-container" action="follow_user.php" method="POST" autocomplete = 'off'  >
            <!-- Título -->
            <div class = "text-center">
                <h2>Estatísticas de <?php echo explode(" ",$statistic['username'])[0] ?></h2>
            </div>
            <?php
                if (!isset($_SESSION['user']['adm']) || !$_SESSION['user']['adm']) {
                    echo set_form_input('ID','id_user',$statistic['id_user'],['readonly' => true]);
                    echo set_form_input('Nome','username',$statistic['username'],['disabled' => true]);
                }
                foreach ($statistic as $key => $value) {
                    if (!isset($_SESSION['user']['adm']) || !$_SESSION['user']['adm']) {
                        echo str_contains($key,'total') ? set_form_input($key,$key,$value,['disabled' => true]) : "";
                    }else{
                        echo set_form_input($key,$key,$value,['disabled' => true]);
                    }
                }
            ?>
        </form>
        <?php require SRC_URL."front/script.php" ?>
    </body>
</html>