<?php
    require "../src/back/config.php";
    if (!isset($_SESSION['users'])) {
        header("Location: select_users.php?all=true");
        //Somehow submit the form so all posts can appear
    }
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
            <h2>Pesquisa de usuários</h2>
        </div>
        <form class = "container form-container" action="select_users.php" method = "POST" autocomplete = "off">
            <!-- Name -->
            <div class = "form-group">
                <label for="username-input" class = "form-label">Nome</label>
                <input type="text" id = "username-input" name = "username" class = "form-control" value = "<?php echo isset($_SESSION['select']['users']["username"]) ? $_SESSION['select']['users']["username"] : "" ?>">
            </div>
            <!-- E-mail -->
            <div class = "form-group">
                <label for="email-input" class = "form-label">E-mail</label>
                <input type="text" id = "email-input" name = "email" class = "form-control" value = "<?php echo isset($_SESSION['select']['users']["email"]) ? $_SESSION['select']['users']["email"] : "" ?>">
            </div>
            <!-- CPF -->
            <div class = "form-group">
                <label for="cpf-input" class = "form-label">CPF</label>
                <input type="text" id = "cpf-input" name = "cpf" class = "form-control" value = "<?php echo isset($_SESSION['select']['users']["cpf"]) ? $_SESSION['select']['users']["cpf"] : "" ?>">
            </div>
            <!-- Feedback -->
            <div>
                <small class = "form-text text-danger">
                    <?php echo isset($_SESSION['feedback']['select']['users']) ? $_SESSION['feedback']['select']['users'] : "" ?>
                </small>
            </div>
            <!-- Pesquisar -->
            <div style = "text-align: right">
                <button type = "submit" class = "btn btn-secondary">Pesquisar</button>
            </div>
        </form>
        <section>
            <!-- Título -->
            <div class = "text-center">
                <h2>Usuários cadastrados</h2>
            </div>
            <table class = "table-container">
                <thead>
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">CPF</th>
                    <th scope="col">Data cadastro</th>
                    <th scope="col">CPF</th>                    
                    <th scope="col" colspan="2">Ações</th>
                </thead>
                <tbody>
                    <?php
                        if (isset($_SESSION['users'])) {
                            //var_dump($_SESSION['users']);
                            foreach ($_SESSION['users'] as $user) {
                                echo "<tr scope = 'row' id = 'id-".$user['id']."' >";
                                echo "<td>".$user['id']."</td>";
                                echo "<td>".$user['username']."</td>";
                                echo "<td>".$user['email']."</td>";
                                echo "<td>".$user['cpf']."</td>";
                                echo "<td>".format_date($user['created_at'])."</td>";
                                echo "<td>".$user['cpf']."</td>";
                                echo "<td>
                                    <div class = 'btn-group' role = 'group' aria-labelledby = 'users actions'>"
                                        .set_link_button('Perfil','profile.php?id='.$user['id'],'btn btn-dark')
                                        .set_link_button('Estatísticas','users_statistics.php?id='.$user['id'],'btn btn-secondary')
                                        .set_link_button($user['following'] ? "Seguindo" : "Seguir",'follow_user.php?id='.$user['id']."&redirect_url=".$_SERVER['REQUEST_URI'],$user['following'] ? "btn btn-success" : "btn btn-primary").
                                    "</div>
                                </td>";
                                //echo "<td>".set_link_button('Perfil','profile.php?id='.$user['id'],'btn btn-dark')."</td>";
                                //echo "<td>".set_link_button('Estatísticas','users_statistics.php?id='.$user['id'],'btn btn-secondary')."</td>";
                                echo "</tr>";
                            }
                            unset($_SESSION['users']);
                        }
                    ?>
                </tbody>
            </table>
        </section>
        <?php require SRC_URL."front/footer.php" ?>
    </body>
</html>