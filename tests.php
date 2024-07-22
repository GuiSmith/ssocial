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
            <form class = "container form-container" method = "POST" action = "tests2.php" enctype="multipart/form-data" >
                <div class = "form-group text-center">
                    <label id = "image-label" for="image-input" class = "form-label">
                        <img id = "label-image" src="media/bootstrap.png" alt="img" width = "50%" height = "50%" style="border: solid 1px black; border-radius: 50%">
                    </label>
                    <input type="file" name = "image_src" style = 'display: none' id = "image-input" required />
                </div>
                <div class = "form-group" style="text-align:right">
                    <button type = "submit" class = "btn btn-success">Enviar</button>
                </div>
                <div class = "text-center">
                    <?php var_dump($_SESSION['feedback']['tests']); ?>
                </div>
            </form>
            <div>
                <img src="http://localhost/ssocial/media/users/13/pfp/eu_669de74c5fcdc.jpeg" alt="img2">
            </div>
        </section>
    </body>
</html>

