<?php

    require "src/back/config.php";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require SRC_URL."/front/head.php" ?>
        <style>
            div {
                margin-bottom: 10rem;
            }
        </style>
    </head>
    <body>
        <?php require SRC_URL."/front/navbar.php" ?>
        

        <?php
        
            $num = 2;

            if($num){
                echo "true";
            }else{
                echo "false";
            }
        
        ?>
    </body>
</html>