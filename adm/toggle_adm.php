<?php

    require "../src/back/config.php";
    checkAuth(true,true);

    if (isset($_GET['id']) && is_natural($_GET['id'])) {
        if ($_SESSION['user']['adm']) {
            $id = $_GET['id'];
            $db = db_conn();
            $name = $db->querySingle("SELECT username FROM users WHERE id = $id");
            if ($db->querySingle("SELECT adm FROM users WHERE id = $id")) {
                $status = 0;
                $text = "$name deixou de ser Administrador";
            }else{
                $status = 1;
                $text = "$name agora é Administrador";
            }   
            if ($db->exec("UPDATE users SET adm = $status")) {
                header("Location: ".USERS_LINK."profile.php?id=$id");
            }else{
                $title = "Falhou";
                $text = "Algo deu errado";
            }
        }else{
            $title = "Sem permissão";
            $text = "Seu usuário precisa ser administrador para mudar o status de administrador de outro usuário!";
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
                <h2><?php echo $title ?></h2>
                <h4><?php echo $text ?></h4>
                <h4>Atualize a tela para alterar o status de administrador</h4>
            </div>
        </section>
    </body>
</html>