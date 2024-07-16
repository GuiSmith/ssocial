<?php

    require "../src/back/config.php";
    if(!isset($_GET['type'])) header("Location: schema.php?type=table");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require SRC_URL."/front/head.php" ?>
    </head>
    <body>
        <?php require SRC_URL."/front/navbar.php" ?>
        
        <section>
            <div class = "text-center">
                <h1>SQLITE SCHEMA</h1>
            </div>
            <div class = "container">
                <?php
            
                    $type = isset($_GET['type']) ? strtolower($_GET['type']) : "";
                    $types = [
                        'table' => 'Tabelas | Tables',
                        'view' => 'Visualizações | Views',
                        'trigger' => 'Gatilhos | Triggers'
                    ];

                    if (array_key_exists($type,$types)) {
                        $db = db_conn();
                        $query = $db->query("SELECT * FROM sqlite_schema WHERE type = '$type' ORDER BY tbl_name ASC");
                        $triggers = [];

                        if ($query) {
                            echo "<div class = 'text-center'><h2>".$types[$type]."</h2></div>";
                            echo "<div class = 'input-group' style = 'margin: 0 auto;text-align:center;display:block'>
                                    <a href = '?type=table' class = 'btn btn-dark'>Tables</a>
                                    <a href = '?type=view' class = 'btn btn-dark'>Views</a>
                                    <a href = '?type=trigger' class = 'btn btn-dark'>Triggers</a>
                                </div>";
                            while ($row = $query->fetchArray(SQLITE3_ASSOC)) {
                                echo "<div class = 'text-justify'><ul>";
                                foreach ($row as $col => $value) {
                                    echo "<li><strong>".ucfirst($col).":</strong> <code>$value</code></li>";
                                }
                                echo "</ul></div>";
                                $triggers[] = $row;
                            }
                        } else {
                            echo "Query failed: " . $db->lastErrorMsg();
                        }
                    }else{
                        if (!empty($type)) {
                            echo "<h2 class = 'text-center'>Tipo inválido: <strong>$type</strong></h2>";
                        }
                    }
                ?>
            </div>
        </section>
    </body>
</html>