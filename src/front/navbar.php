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
          if(logged()){
            //Logged
            set_nav_link(USERS_LINK."profile.php","Perfil");
            set_nav_link(USERS_LINK."crud/my_data.php","Meus dados");
            set_nav_link(USERS_LINK."users_statistics.php","Estatísticas");
            set_nav_link(USERS_LINK."visits.php","Visitas");            
            set_nav_link(USERS_LINK."auth/log_out.php","Sair");
            set_nav_link(BASE_LINK."tests.php","Testes");
          }else{
            //Not logged
            set_nav_link(USERS_LINK."auth/login.php","Entrar");
            set_nav_link(USERS_LINK."crud/signin.php","Registrar");
          }
          set_nav_link(USERS_LINK."users.php","Usuários");
        ?>
    </ul>
</navbar>

<?php

  function set_link_button($text,$href,$class){
    return "<a href = '$href' class = '$class'>$text</a>";
  }

  function set_form_input($label,$column,$value,$options = []){
    $input = "<div class = 'form-group'>";
    $input .= "<label for = '$column-input' class = 'form-label'>$label</label>";
    $input .= "<input type = 'text' id = '$column-input' name = '$column' class = 'form-control' value = '$value' ";
    $input .= isset($options['readonly']) ? "readonly" : "";
    $input .= isset($options['disabled']) ? "disabled" : "";
    $input .= ">";
    $input .= "</div>";
    return $input;
  }

?>