<?php

    if ($_SERVER["REQUEST_METHOD"] == "POST" || isset($_GET['all']) && $_GET['all']) {
        require "../src/back/config.php";
        require SRC_URL."back/functions.php";
        $db = db_conn();

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            //Se a requisição foi via POST, pegar campos inseridos
            $_SESSION['select']['users']['id'] = $id = get_input($_POST['id']);
            $_SESSION['select']['users']['username'] = $username = get_input($_POST['username']);
            $_SESSION['select']['users']['email'] = $email = get_input($_POST['email']);
            $_SESSION['select']['users']['cpf'] = $cpf = getCPF(get_input($_POST['cpf']));
        }else{
            //Se a requisição foi via GET, considerar os filtros como vazio (pesquisar tudo e todos)
            $_SESSION['select']['users']['id'] = $id = "";
            $_SESSION['select']['users']['username'] = $username = "";
            $_SESSION['select']['users']['email'] = $email = "";
            $_SESSION['select']['users']['cpf'] = $cpf = "";
        }
        $cols = [];

        //Inserindo filtros de pesquisa
        foreach ($_SESSION['select']['users'] as $col => $value) {
            if (!empty($value)) {
                $cols[$col] = $value;
            }
        }

        //Retornando usuários
        $users = get_users($cols);

        if ($users) {
            //Se foram encontrados usuários com os filtros, retorna-los
            $_SESSION['users'] = $users;
        }else{
            //Se não foram encontrados usuários com os filtros, informar ao usuário
            $_SESSION['feedback']['select']['users'] = "Nenhum usuário se enquadra nos parâmetros";
        }
        //Dump para debugging
        /*
        echo "<br><br>Dados: ";
        var_dump($_SESSION['select']['users']);
        echo "<br><br>Colunas: ";
        var_dump($cols);
        echo "<br><br>Usuários: ";
        var_dump($users);
        */
        header("Location: users.php");
    }
?>