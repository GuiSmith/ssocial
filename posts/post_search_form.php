<form class = "container form-container" action="select_posts.php" method = "POST" autocomplete = "off">
    <!-- Título -->
    <div class = "text-center">
        <h2>Pesquisa de postagens</h2>
    </div>
    <!-- ID -->
    <div class = "form-group">
        <label for="id-input" class = "form-label">ID Postagem</label>
        <input type="text" id = "id-input" name = "id" class = "form-control" value = "<?php echo isset($_SESSION['select']['posts']["id"]) ? $_SESSION['select']['posts']["id"] : "" ?>">
    </div>
    <!-- ID usuário -->
    <div class = "form-group">
        <label for="id_user-input" class = "form-label">ID Usuário</label>
        <input type="text" id = "id_user-input" name = "id_user" class = "form-control" value = "<?php echo isset($_SESSION['select']['posts']["id_user"]) ? $_SESSION['select']['posts']["id_user"] : "" ?>">
    </div>
    <!-- Name -->
    <div class = "form-group">
        <label for="username-input" class = "form-label">Usuário</label>
        <input type="text" id = "username-input" name = "username" class = "form-control" value = "<?php echo isset($_SESSION['select']['posts']["username"]) ? $_SESSION['select']['posts']["username"] : "" ?>">
    </div>
    <!-- Texto -->
    <div class = "form-group">
        <label for="text-input" class = "form-label">Texto</label>
        <input type="text" id = "text-input" name = "text" class = "form-control" value = "<?php echo isset($_SESSION['select']['posts']["text"]) ? $_SESSION['select']['posts']["text"] : "" ?>">
    </div>
    <div class = "form-group text-center">
        <small class = "form-text text-danger">
            <?php echo (isset($_SESSION['feedback']['select']['posts']['text'])) ? $_SESSION['feedback']['select']['posts']['text'] : ""; ?>
        </small>
    </div>
    <!-- Página de redirecionar -->
    <input type="hidden" name = "redirect_url" value = "<?php echo $_SERVER['REQUEST_URI'] ?>" >
    <!-- Pesquisar -->
    <div style = "text-align: right">
        <button type = "submit" class = "btn btn-secondary">Pesquisar</button>
    </div>
</form>