<?php

    require "../src/back/config.php";
    if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {
        $id = $_GET['id'];
        $self = logged() && $_SESSION['user']['id'] == $id ? true : false;
    }else{
        checkAuth(true);
        $id = $_SESSION['user']['id'];
        $self = true;
    }
    $profile = get_users(['id' => $id],true); //$profile_query->fetchArray(SQLITE3_ASSOC);
    if (!$profile){
        //Se não houve usuário encontrado com o ID
        die("
            <div style = 'text-align: center'>
                <h2>Oops! Algo deu errado...</h2>
                <h4>O usuário com ID $id não existe no sistema</h4>
                <h4>Isso pode ter acontecido porque o usuário nunca foi cadastrado ou deletou a própria conta!</h4>
                <h4><a href = 'profile.php' >Clique aqui</a> para voltar ao seu perfil</h4>
            </div>
        ");
    }else{
        //var_dump($profile);
    }
    if ($self) {
        $button_tag = "a";
        $button_text = "Editar";
        $button_class = "btn btn-secondary";
        $link = USERS_LINK."crud/my_data.php";
        $button_attributes = "href = '$link'";
    }else{
        if (logged()) {
            $db = db_conn();
            $db->exec("INSERT INTO users_visits (id_host,id_guest) VALUES ($id,".$_SESSION['user']['id'].")");
        }
        $button_tag = "button";
        $button_attributes = "type = 'submit'";
        if ($profile['following']) {
            $button_text = "Seguindo";
            $button_class = "btn btn-success";
        }else{
            $button_text = "Seguir";
            $button_class = "btn btn-primary";
        }
    }
    $cols = ['id_user' => $profile['id']];
    $posts = get_posts($cols);
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
            <h2>
                <?php
                    if ($self) {
                        echo "Meu Perfil";
                    }else{
                        echo "Perfil de ".explode(" ",$profile['username'])[0];
                    }
                ?>
            </h2>
        </div>
        <form class = "container form-container" action="follow_user.php?redirect_url=<?php echo $_SERVER['REQUEST_URI'] ?>" method="POST" autocomplete = 'off'  >
            <?php
                if (logged() && $_SESSION['user']['adm'] && $self == false) {
                    echo "<div class = 'input-group'>";
                    echo set_link_button('Deletar',USERS_LINK.'crud/delete_user.php?id='.$profile['id'],'btn btn-danger');
                    echo set_link_button('ADM',ADM_LINK.'toggle_adm.php?id='.$profile['id'],$profile['adm'] ? 'btn btn-success' : 'btn btn-primary');
                    echo "</div>";
                }else{

                }
                echo set_form_input('ID','id',$profile['id'],['readonly' => true]);
                echo set_form_input('Nome','username',$profile['username'],['disabled' => true]);
                echo set_form_input('E-mail','email',$profile['email'],['disabled' => true]);
                echo set_form_input('CPF','cpf',$profile['cpf'],['disabled' => true]);
                echo set_form_input('Se cadastrou em','created_at',format_date($profile['created_at']),['disabled' => true]);
                echo set_form_input('Atualizou os próprios dados pela última vez em','updated_at',format_date($profile['updated_at']),['disabled' => true]);
                echo set_form_input('Entrou pela última vez em','logged_at',format_date($profile['logged_at']),['disabled' => true]);
                echo set_form_textarea('Biografia','bio',$profile['bio'],['disabled' => true]);
                echo set_form_input('Seguiu pela primeira vez','followed_first_at',$profile['followed_first_at'],['disabled' => true]);
                echo set_form_input('Seguindo desde','following_since',$profile['following_since'],['disabled' => true]);
            ?>
            <!-- Buttons -->
            <div class = "row" >
                <div class = "col-lg-6 col-md-6 col-sm-12" style = "text-align: left">
                    <a class = "btn btn-secondary" href = "users_statistics.php?id=<?php echo $profile['id'] ?>" >Estatísticas</a>
                </div>
                <div class = "col-lg-6 col-md-6 col-sm-12" style = "text-align: right">
                    <?php echo set_button($button_tag,$button_text,$button_class,$button_attributes) ?>
                </div>
            </div>
        </form>
        <section>
            <div class = 'text-center' style = "display: <?php echo empty($posts) ? 'none' : 'block' ?>">
                <h2>
                    <?php
                        if ($self) {
                            echo "Minhas postagens";
                        }else{
                            echo "Postagens de ".explode(" ",$profile['username'])[0];
                        }
                    ?>
                </h2>
            </div>
            <?php
                if (!empty($posts)) {
                    foreach ($posts as $post) {
                        echo set_post_form($post);
                    }
                }
            ?>
        </section>
        <?php require SRC_URL."front/script.php" ?>
    </body>
</html>