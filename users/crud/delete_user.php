<?php

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        require "../../src/back/config.php";
        checkAuth(true);
        $db = db_conn();

        $id = isset($_GET['id']) && is_natural($_GET['id']) ? $_GET['id'] : 0;

        if ($id <= 0) die("ID inválido");
        if ($_SESSION['user']['id'] != $id) {
            header("Location: ".USERS_LINK."crud/my_data.php");
        }else{
            $del_SQL = "DELETE FROM users WHERE id = :id";
            $del_query = $db->prepare($del_SQL);
            $del_query->bindValue(':id',$id,SQLITE3_INTEGER);
            if ($del_query->execute()) {
                echo "ID $id deletado com sucesso!";
                header("Location: ../auth/log_out.php");
            }else{
                echo "O ID $id não pôde ser deletado pois algo deu errado";
            }
        }
    }

?>