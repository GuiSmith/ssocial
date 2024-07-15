<?php

    if ($_SERVER["REQUEST_METHOD"] == "POST" || isset($_GET['all']) && $_GET['all']) {
        require "../src/back/config.php";
        require SRC_URL."back/functions.php";
        $db = db_conn();

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $_SESSION['select']['users']['username'] = $username = get_input($_POST['username']);
            $_SESSION['select']['users']['email'] = $email = get_input($_POST['email']);
            $_SESSION['select']['users']['cpf'] = $cpf = getCPF(get_input($_POST['cpf']));
        }else{
            $_SESSION['select']['users']['username'] = $username = "";
            $_SESSION['select']['users']['email'] = $email = "";
            $_SESSION['select']['users']['cpf'] = $cpf = "";
        }
        $cols = [];

        foreach ($_SESSION['select']['users'] as $col => $value) {
            if (!empty($value)) {
                $cols[$col] = $value;
            }
        }

        $users = get_users($cols);

        if ($users) {
            $_SESSION['users'] = $users;
        }else{
            $_SESSION['feedback']['select']['users'] = "Nenhum usuário se enquadra nos parâmetros";
            /*
            echo "<br>Dados: ";
            var_dump($_SESSION['select']['users']);
            echo "<br>Colunas: ";
            var_dump($cols);
            echo "<br>Usuários: ";
            var_dump($users);
            */
        }
        header("Location: users.php");
    }
?>