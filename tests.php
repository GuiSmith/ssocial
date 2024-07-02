<?php

    require "src/back/config.php";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require SRC_URL."/front/head.php" ?>
    </head>
    <body>
        <?php require SRC_URL."/front/navbar.php" ?>
        <h2 class = "text-center">Testes</h2>
        
        <div class = "row container">
            <!-- Limpar sessão -->
            <a class = "btn btn-secondary" href="<?php echo AUTH_LINK ?>log_out.php">Limpar sessão</a>
            <!-- Usuário logado -->
            <div class = "col-lg-6 col-md-6 col-sm-12" style = "overflow: auto">
                <p>
                    <h4>Usuário logado: <?php echo $_SESSION['user']['username'] ?></h4>
                    <ul>
                        <?php
                            if (isset($_SESSION['user'])) {
                                foreach($_SESSION['user'] as $key => $value){
                                    echo "<li>$key: $value</li>";
                                }
                            }else{
                                echo "Login não realizado";
                            }
                        ?>
                    </ul>
                </p>
            </div>
            <!-- Usuário específico -->
            <div class = "col-lg-6 col-md-6 col-sm-12 " style = "overflow: auto">
                <!-- Pegar usuário por coluna -->
                <p>
                    <h4>Usuário escolhido: </h4>
                    <ul>
                        <?php
                            $col = "email";
                            $value = "guilhermessmith2014@gmail.com";
                            $user = get_user_by($col,$value);
                            echo "Filtro: $col | Valor: $value";
                            if ($user) {
                                foreach($user as $key => $value){
                                    echo "<li>$key: $value</li>";
                                }
                            }else{
                                echo "Usuário com '$col' igual a '$value' não encontrado";
                            }
                        ?>
                    </ul>
                </p>
            </div>
        </div>
        <?php
        
            get_users([
                "username" => 'gui',
                "email" => '',
                "cpf" => ''
            ]);
        
        ?>
    </body>
</html>