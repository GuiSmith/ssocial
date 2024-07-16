<?php

    require "src/back/config.php";
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
                <h1>Testes</h1>
            </div>
            <div class = "container">
                
                <?php
                    $db = db_conn();
                    $pass = password_hash("46999198879",PASSWORD_DEFAULT);
                    if ($db->exec("UPDATE users SET pass = '$pass' WHERE id = 5")) {
                        echo "Senha atualizada";
                    }else{
                        echo "Senha não atualizada";
                    }
                ?>
            </div>
        </section>
    </body>
</html>

