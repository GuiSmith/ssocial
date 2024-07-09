<?php

    require "../src/back/config.php";
    if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {
        $id = $_GET['id'];
    }else{
        checkAuth(true);
        $id = $_SESSION['user']['id'];
    }
    $profile = get_user_by('id',$id);
    $profile['following_since'] = "";
    $profile['followed_first_at'] = "";
    $profile['following'] = false;    
    $db = db_conn();

    if (logged()) {
        $id_user_follower = $_SESSION['user']['id'];
        $id_user_followed = $profile['id'];
        
        $se_query = $db->query("SELECT * FROM users_follow WHERE id_user_follower = $id_user_follower AND id_user_followed = $id_user_followed");
        $follower_data = $se_query->fetchArray(SQLITE3_ASSOC);
        if ($follower_data) {
            $profile['following'] = $follower_data['active'];
            if ($profile['following']) {
                $profile['following_since'] = $follower_data['updated_at'] ? $follower_data['updated_at'] : $follower_data['created_at'];
            }
            $profile['followed_first_at'] = $follower_data['created_at'];
        }else{
            $profile['following'] = false;
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
            <!-- ID -->
            <div class = "form-group">
                <label for="id-input" class = "form-label">ID</label>
                <input type="text" id = "id-input" name = "id" class = "form-control" <?php echo "value = ".$profile['id'] ?> readonly>
            </div>
            <!-- Name -->
            <div class = "form-group">
                <label for="username-input" class = "form-label">Nome</label>
                <input type="text" id = "username-input" name = "username" class = "form-control" <?php echo "value = ".$profile['username'] ?> disabled>
            </div>
            <!-- E-mail -->
            <div class = "form-group">
                <label for="email-input" class = "form-label">E-mail</label>
                <input type="email" id = "email-input" name = "email" class = "form-control" <?php echo "value = ".$profile['email'] ?> disabled>
            </div>
            <!-- CPF -->
            <div class = "form-group">
                <label for="cpf-input" class = "form-label">CPF</label>
                <input type="text" id = "cpf-input" name = "cpf" class = "form-control" <?php echo "value = ".$profile['cpf'] ?> disabled>
            </div>
            <!-- Data criação -->
            <div class = "form-group">
                <label for="created-at-input" class = "form-label">Se cadastrou em</label>
                <input type="text" id = "created-at-input" class = "form-control" value = "<?php echo format_date($profile["created_at"]) ?>" disabled >
            </div>
            <!-- Data atualização -->
            <div class = "form-group">
                <label for="updated-at-input" class = "form-label">Atualizou o próprio perfil pela última vez em</label>
                <input type="text" id = "updated-at-input" class = "form-control" value = "<?php echo format_date($profile['updated_at']) ?>" disabled >
            </div>
            <!-- Último login -->
            <div class = "form-group">
                <label for="updated-at-input" class = "form-label">Entrou pela última vez em</label>
                <input type="text" id = "updated-at-input" class = "form-control" value = "<?php echo format_date($profile['logged_at']) ?>" disabled >
            </div>
            <!-- Bio -->
            <div class = "form-group">
                <label for="bio-input" class = "form-label">Biografia</label>
                <textarea name="bio" id="bio-input" cols="30" rows="3" class = "form-control" disabled ><?php echo $profile['bio'] ?> </textarea>
            </div>
            <!-- Seguindo -->
            <div class = "form-group">
                <label for="following-input" class = "form-label">Seguindo</label>
                <input type="text" id = "following-input" class = "form-control" value = "<?php echo $profile['total_following'] ?>" disabled >
            </div>
            <!-- Seguidores -->
            <div class = "form-group">
                <label for="followers-input" class = "form-label">Seguidores</label>
                <input type="text" id = "followers-input" class = "form-control" value = "<?php echo $profile['total_followers'] ?>" disabled >
            </div>
            <!-- Seguiu pela primeira vez em -->
            <div class = "form-group">
                <label for="followed-at-first-input" class = "form-label">Seguiu pela primeira vez em</label>
                <input type="text" id = "followed-at-first-input" class = "form-control" value = "<?php echo isset($profile['followed_first_at']) ? format_date($profile['followed_first_at']) : "" ?>" disabled >
            </div>
            <!-- Seguindo desde -->
            <div class = "form-group">
                <label for="following-since-input" class = "form-label">Seguindo desde</label>
                <input type="text" id = "following-since-input" class = "form-control" value = "<?php echo isset($profile['following_since']) ? format_date($profile['following_since']) : "" ?>" disabled >
            </div>
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
                    <button type = "submit" class = "btn btn-success" <?php echo $_SESSION['user']['id'] == $profile['id'] ? "disabled" : "" ?>>
                        <?php echo $profile['following'] ? "Seguindo" : "Seguir" ?>
                    </button>
                </div>
            </div>
        </form>
        <?php require SRC_URL."front/script.php" ?>
        <script>

        </script>
    </body>
</html>