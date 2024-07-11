<?php

    require "../src/back/config.php";
    if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {
        $id = $_GET['id'];
    }else{
        checkAuth(true);
        $id = $_SESSION['user']['id'];
    }
    $db = db_conn();
    if (logged() && $id != $_SESSION['user']['id']) {
        //Se o usuário estiver logado e estiver vendo o perfil de outro usuário
        $self = false;
        $sql = "SELECT * FROM profile WHERE id = $id AND (id_user_follower = ".$_SESSION['user']['id']." OR id_user_follower IS NULL)";
        $db->exec("INSERT INTO users_visits (id_host,id_guest) VALUES ($id,".$_SESSION['user']['id'].")");
    }else{
        //Se o usuário não estiver logado ou se estiver vendo o próprio registro
        $sql = "SELECT * FROM users WHERE id = $id";
        $self = isset ($_SESSION['user'])&& $id == $_SESSION['user']['id'] ? true : false;
    }
    $profile_query = $db->query($sql);
    $profile = $profile_query->fetchArray(SQLITE3_ASSOC);
    $dynamic_inputs = ['following','followed_first_at','following_since'];
    foreach ($dynamic_inputs as $input) {
        if (!isset($profile[$input])) {
            $profile[$input] = '';
        }
    }
    
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
                <h2>Perfil de <?php echo explode(" ",$profile['username'])[0] ?></h2>
            </div>
            <?php
                echo set_form_input('ID','id',$profile['id'],['readonly' => true]);
                echo set_form_input('Nome','username',$profile['username'],['disabled' => true]);
                echo set_form_input('E-mail','email',$profile['email'],['disabled' => true]);
                echo set_form_input('CPF','cpf',$profile['cpf'],['disabled' => true]);
                echo set_form_input('Se cadastrou em','created_at',$profile['created_at'],['disabled' => true]);
                echo set_form_input('Entrou pela última vez em','updated_at',format_date($profile['updated_at']),['disabled' => true]);
                echo set_form_input('Biografia','updated_at',format_date($profile['updated_at']),['disabled' => true]);
                echo set_form_input('Seguiu pela primeira vez','followed_first_at',$profile['followed_first_at'],['disabled' => true]);
                echo set_form_input('Seguindo desde','following_since',$profile['following_since'],['disabled' => true]);
            ?>
            <!-- Buttons -->
            <div class = "row" >
                <div class = "col-lg-3 col-md-6 col-sm-12" style = "text-align: left">
                    <a class = "btn btn-danger" href="report_user.php?id=<?php echo $profile['id'] ?>">Denunciar</a>
                </div>
                <div class = "col-lg-6 col-md-6 col-sm-12" style = "text-align: left">
                    <small class = "text-form text-muted">
                        <?php
                            if (isset($_SESSION['feedback']['follow'])) {
                                echo $_SESSION['feedback']['follow'];
                                unset($_SESSION['feedback']['follow']);
                            }
                        ?>
                    </small>
                </div>
                <div class = "col-lg-3 col-md-6 col-sm-12" style = "text-align: right">
                    <button type = "submit" class = "btn btn-success" <?php echo $self ? "disabled" : "" ?>>
                        <?php echo isset($profile['following']) && $profile['following'] ? "Seguindo" : "Seguir" ?>
                    </button>
                </div>
            </div>
        </form>
        <?php require SRC_URL."front/script.php" ?>
    </body>
</html>