<?php
    require "../src/back/config.php";
    checkAuth(true);
    if (isset($_GET['mode'])) {
        if ($_GET['mode'] == 'guest') {
            $_SESSION['mode'] = 'guest';
        }else{
            if ($_GET['mode'] == 'host') {
                $_SESSION['mode'] = 'host';
            }else{
                $_SESSION['mode'] = 'all';
            }
        }
    }else{
        if (!isset($_SESSION['mode'])) {
            $_SESSION['mode'] = "all";
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
        <article class = " container">
            <div class = "text-center">
                <h2>Em construção!</h2>
                <h4>Esta tela encontra-se em construção</h4>
            </div>
            <p class = "text-justify">
                O objetivo futuro desta tela é que você consiga buscar e visualizar as visitas realizadas por você ou a seu perfil utilizando os filtros de nome, e-mail, cpf, data, etc. Esta tela foi criada apenas para manter o mapeamento de criação das visitas quando você visualiza um perfil que não é o seu, quando o projeto todo for finalizado. Esta tela será continuada.
            </p>
        </article>
        <section id = "visits-table">
            <!-- Título -->
            <div class = "text-center">
                <h2>Visitas</h2>
                <h5>Cada linha representa uma visita realizada por você a outro perfil ou de outro perfil ao seu!</h5>
            </div>
            <!-- Buttons -->
            <div class = "text-center">
                <div class = "btn-group mb-3">
                    <?php
                        echo set_link_button(
                            'Visitas realizadas',
                            '?mode=guest',
                            'btn '.($_SESSION['mode'] == 'guest' ? 'btn-dark' : 'btn-secondary')
                        );
                        echo set_link_button(
                            'Todos',
                            '?mode=all',
                            'btn '.($_SESSION['mode'] == 'all' ? 'btn-dark' : 'btn-secondary')
                        );
                        echo set_link_button(
                            'Visitas recebidas',
                            '?mode=host',
                            'btn '.($_SESSION['mode'] == 'host' ? 'btn-dark' : 'btn-secondary')
                        );
                    ?>
                </div>
            </div>
            <!-- Table -->
            <table class = "table-stripped table-container">
                <thead>
                    <th scope="col">Linha</th>
                    <th scope="col">ID Visitante</th>
                    <th scope="col">Visitante</th>
                    <th scope="col">ID Hóspede</th>
                    <th scope="col">Hóspede</th>
                    <th scope="col">Data da visita</th>
                </thead>
                <tbody>
                    <?php
                        $db = db_conn();
                        $sql = "SELECT id_guest, id_host, guest,host,created_at FROM visits";
                        switch($_SESSION['mode']){
                            case 'guest':
                                $sql .= " WHERE id_guest = ".$_SESSION['user']['id'];
                                break;
                            case 'host':
                                $sql .= " WHERE id_host = ".$_SESSION['user']['id'];
                                break;
                            case 'all':
                                $sql .= " WHERE id_guest = ".$_SESSION['user']['id']." OR id_host = ".$_SESSION['user']['id'];
                                break;
                        } 
                        $pages = getTablePages($sql);
                        $current_page = isset($_GET['page']) && $pages > $_GET['page'] ? $_GET['page'] : 0;
                        $sql .= " LIMIT ".TABLE_MAX_LINES." OFFSET ".$current_page*TABLE_MAX_LINES;
                        $query = $db->query($sql);
                        $visits = [];
                        if ($query) {
                            while ($row = $query->fetchArray(SQLITE3_ASSOC)) {
                                $visits[] = $row;
                                echo "<tr scope = 'row'>";
                                echo "<td>".count($visits)."</td>";
                                echo "<td>".$row['id_guest']."</td>";
                                echo "<td>".$row['guest']."</td>";
                                echo "<td>".$row['id_host']."</td>";
                                echo "<td>".$row['host']."</td>";
                                echo "<td>".format_date($row['created_at'])."</td>";
                                echo "</tr>";
                            }
                        }
                    ?>
                </tbody>
                <!-- Pagination Controls -->
                <?php
                    echo get_pagination_controls($pages);
                ?>
            </table>
        </section>
    </body>
</html>