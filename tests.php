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
        <h2 class = "text-center">Testes</h2>
        <?php
            $um = "um";
            $um .= " e dois";
            echo $um;

            echo set_form_input('ID','id_user',1,['readonly' => true]);
            var_dump(set_form_input('ID','id_user',1,['readonly' => true]));

        ?>
    </body>
</html>