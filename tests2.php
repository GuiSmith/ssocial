<?php
    require "src/back/config.php";
    //var_dump($_FILES['image_src']);
    $_SESSION['feedback']['tests'] = upload_image(5,'pfp',$_FILES['image_src']);
    echo "<p>".$_SESSION['feedback']['tests']."</p>";
    //header("Location: tests.php");

?>