<?php

    require "../src/back/config.php";
    checkAuth(true);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require SRC_URL."front/head.php" ?>
    </head>
    <body>
        <?php require SRC_URL."front/navbar.php" ?>
        <form class = "container form-container" action="select_users.php" method = "POST" autocomplete = "off">
            <!-- Título -->
            <div class = "text-center">
                <h2>Pesquisa de usuários</h2>
            </div>
            <!-- Name -->
            <div class = "form-group">
                <label for="username-input" class = "form-label">Nome</label>
                <input type="text" id = "username-input" name = "username" class = "form-control" value = "<?php echo isset($_SESSION['select']["username"]) ? $_SESSION['select']["username"] : "" ?>">
                <small class = "form-text text-danger">
                    <?php echo (isset($_SESSION['feedback']['username'])) ? $_SESSION['feedback']['username'] : ""; ?>
                </small>
            </div>
            <!-- E-mail -->
            <div class = "form-group">
                <label for="email-input" class = "form-label">E-mail</label>
                <input type="text" id = "email-input" name = "email" class = "form-control" value = "<?php echo isset($_SESSION['select']["email"]) ? $_SESSION['select']["email"] : "" ?>">
                <small class = "form-text text-danger">
                    <?php echo (isset($_SESSION['feedback']['email'])) ? $_SESSION['feedback']['email'] : ""; ?>
                </small>
            </div>
            <!-- CPF -->
            <div class = "form-group">
                <label for="cpf-input" class = "form-label">CPF</label>
                <input type="text" id = "cpf-input" name = "cpf" class = "form-control" value = "<?php echo isset($_SESSION['select']["cpf"]) ? $_SESSION['select']["cpf"] : "" ?>">
                <small class = "form-text text-danger">
                    <?php echo (isset($_SESSION['feedback']['cpf'])) ? $_SESSION['feedback']['cpf'] : "" ?>
                </small>
            </div>
            <!-- Pesquisar -->
            <div style = "text-align: right">
                <button type = "submit" class = "btn btn-success">Pesquisar</button>
            </div>
        </form>
        <section class = "container">
            <!-- Título -->
            <div class = "text-center">
                <h2>Usuários cadastrados</h2>
            </div>
            <table>
                <thead>
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">CPF</th>
                    <th scope="col">Seguindo</th>
                    <th scope="col">Seguidores</th>
                    <th scope="col">Postagens</th>
                    <th scope="col">Data cadastro</th>
                    <th scope="col">Data atualização</th>
                    <th scope="col">Último login</th>
                </thead>
                <tbody>
                    <?php

                        if (isset($_SESSION['users'])) {
                            //var_dump($_SESSION['users']);
                            foreach ($_SESSION['users'] as $user) {
                                echo "<tr scope = 'row' onclick = 'checkProfile(".$user['id'].")'>";
                                echo "<td>".$user['id']."</td>";
                                echo "<td>".$user['username']."</td>";
                                echo "<td>".$user['email']."</td>";
                                echo "<td>".$user['cpf']."</td>";
                                echo "<td>".$user['total_following']."</td>";
                                echo "<td>".$user['total_followers']."</td>";
                                echo "<td>".$user['total_posts']."</td>";
                                echo "<td>".format_date($user['created_at'])."</td>";
                                echo "<td>".format_date($user['updated_at'])."</td>";
                                echo "<td>".format_date($user['logged_at'])."</td>";
                            }
                            unset($_SESSION['users']);
                        }
                    ?>
                </tbody>
            </table>
        </section>
        <script>
            function checkProfile(id){
                window.location.href = `profile.php?id=${id}`;
            }
        </script>
    </body>
</html>