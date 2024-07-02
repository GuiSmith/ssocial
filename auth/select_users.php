<?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require "../src/back/config.php";
        require SRC_URL."back/functions.php";
        $db = db_conn();

        $_SESSION['select']['username'] = $username = get_input($_POST['username']);
        $_SESSION['select']['email'] = $email = get_input($_POST['email']);
        $_SESSION['select']['cpf'] = $cpf = getCPF(get_input($_POST['cpf']));
        $cols = [];

        foreach ($_SESSION['select'] as $col => $value) {
            if (!empty($value)) {
                $cols[$col] = $value;
            }
        }

        $users = get_users($cols);

        if ($users) {
            $_SESSION['users'] = $users;
            header("Location: users.php");
        }else{
            echo "Houve um erro com a função!";
            var_dump($users);
        }
    }

?>