<?php

    require "../src/back/config.php";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require SRC_URL."front/head.php" ?>
    </head>
    <body>
        <?php require SRC_URL."front/navbar.php" ?>
        <article class = " container">
            <div class = "text-center">
                <h2>Em construção!</h2>
                <h4>Esta tela encontra-se em construção</h4>
            </div>
            <p class = "text-justify">
                O objetivo futuro desta tela é que você consiga buscar e visualizar as visitas realizadas por você ou a seu perfil utilizando os filtros de nome, e-mail, cpf, data, etc. Esta tela foi criada apenas para manter o mapeamento de criação das visitas quando você visualiza um perfil que não é o seu, quando o projeto todo for finalizado. Esta tela será continuada.
            </p>
        </article>
        <!-- Título -->
        <div class = "text-center">
            <h2>Visitas</h2>
            <h5>Cada linha representa uma visita realizada por você a outro perfil ou de outro perfil ao seu!</h5>
        </div>
        <section class = "table-container">
            <table>
                <thead>
                    <th scope="col">ID</th>
                    <th scope="col">Data visita</th>
                    <th scope="col">ID Visita</th>
                    <th scope="col">ID Hóspede</th>
                </thead>
                <tbody>
                    <?php

                        $db = db_conn();
                        $query = $db->query("SELECT * FROM users_visits WHERE id_guest = ".$_SESSION['user']['id']." OR id_host = ".$_SESSION['user']['id']);
                        $visits = [];
                        while ($row = $query->fetchArray(SQLITE3_ASSOC)) {
                            $visits[] = $row;
                        }
                        foreach ($visits as $visit) {
                            echo "<tr scope = 'row'>";
                            echo "<td>".$visit['id']."</td>";
                            echo "<td>".format_date($visit['created_at'])."</td>";
                            echo "<td>".$visit['id_guest']."</td>";
                            echo "<td>".$visit['id_host']."</td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </section>
    </body>
</html>