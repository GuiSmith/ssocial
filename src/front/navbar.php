<?php 

  function set_nav_link($path,$text){
    echo "<li class='nav-item'><a href = '$path' class = 'nav-link'>$text</a></li>";
  }

?>

<navbar class = "navbar navbar-expand-lg">

    <!-- Links -->
    <ul class="navbar-nav mr-auto">
        <!-- Project -->
        <?php

          set_nav_link(MAIN_LINK."index.php","Sobre");
          if(isset($_SESSION["user"])){
            //Logged
            set_nav_link(AUTH_LINK."my_data.php","Perfil");
            set_nav_link(AUTH_LINK."users.php","Usuários");
            set_nav_link(AUTH_LINK."log_out.php","Sair");
          }else{
            //Not logged
            set_nav_link(AUTH_LINK."login.php","Entrar");
            set_nav_link(AUTH_LINK."signin.php","Registrar");
          }
          set_nav_link(BASE_LINK."tests.php","Testes");

        ?>
    </ul>
</navbar>