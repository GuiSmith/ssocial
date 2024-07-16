<navbar class = "navbar navbar-expand-lg">

    <!-- Links -->
    <ul class="navbar-nav mr-auto">
        <!-- Project -->
        <?php
          set_nav_link(MAIN_LINK."index.php","Sobre");
          set_nav_link(BASE_LINK."index.html","Instalação");
          set_nav_link(USERS_LINK."users.php","Usuários");
          set_nav_dropdown("Postagens", POSTS_LINK."posts.php",[
            ["path" => POSTS_LINK."crud/post.php", "text" => "Novo"],
            ["path" => POSTS_LINK."posts_table.php", "text" => "Tabela"]
          ]);
          if(logged()){
            //Logged
            set_nav_dropdown("Perfil",USERS_LINK.'profile.php',[
              ["path" => USERS_LINK."crud/my_data.php", "text" => "Dados"],
              ["path" => USERS_LINK."users_statistics.php", "text" => "Estatísticas"],
              ["path" => USERS_LINK."visits.php", "text" => "Visitas"]
            ]);
            if ($_SESSION['user']['adm']) {
              set_nav_dropdown("ADM", ADM_LINK."schema.php",[
                ["path" => BASE_LINK."tests.php", "text" => "Testes"]
              ]);
              //set_nav_link(BASE_LINK."tests.php","Testes");
            }
            set_nav_link(USERS_LINK."auth/log_out.php","Sair");
          }else{
            //Not logged
            set_nav_link(USERS_LINK."auth/login.php","Entrar");
            set_nav_link(USERS_LINK."crud/signin.php","Registrar");
          }
          /*
          set_nav_dropdown("Mais", [
            ["path" => USERS_LINK."auth/log_out.php", "text" => "Sair"],
            ["path" => BASE_LINK."tests.php", "text" => "Testes"]
          ]);
          */
        ?>
    </ul>
</navbar>

<?php

  function set_nav_link($path,$text){
    echo "<li class='nav-item'><a href = '$path' class = 'nav-link'>$text</a></li>";
  }

  function set_nav_dropdown($text, $href, $items) {
    echo "<li class='nav-item dropdown'>";
    echo "<a class='nav-link dropdown-toggle' href='$href' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>$text</a>";
    echo "<div class='dropdown-menu' aria-labelledby='navbarDropdown'>";
    foreach ($items as $item) {
        echo "<a class='dropdown-item' href='{$item['path']}'>{$item['text']}</a>";
    }
    echo "</div>";
    echo "</li>";
  }

  function set_post_options_dropdown($postId, $options) {
    if (!empty($options)) {
      $element = "<div class='dropdown post-options'>";
      $element .= "<span class=' dropdown-toggle' id='postOptionsDropdown$postId' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>&#x2026;</span>";
      $element .= "<div class='dropdown-menu' aria-labelledby='postOptionsDropdown$postId'>";
      foreach ($options as $option) {
        $element .= "<a class='dropdown-item' href='{$option['path']}?id=$postId'>{$option['text']}</a>";
      }
      $element .= "</div>";
      $element .= "</div>";
    }else{
      $element = "";
    }
    return $element;
  }

  function set_button($tag,$text,$class,$attributes) {
    return "<$tag $attributes class = '$class' >$text</$tag>";
  }

  function set_link_button($text,$href,$class){
    return "<a href = '$href' class = '$class'>$text</a>";
  }

  function set_form_input($label,$column,$value,$options = []){
    $input = "<div class = 'form-group'>";
    $input .= "<label for = '$column-input' class = 'form-label'>$label</label>";
    $input .= "<input type = 'text' id = '$column-input' name = '$column' class = 'form-control' value = '$value' ";
    $input .= isset($options['readonly']) ? " readonly " : "";
    $input .= isset($options['disabled']) ? " disabled " : "";
    $input .= isset($options['required']) ? " required " : "";
    $input .= ">";
    $input .= "</div>";
    return $input;
  }

  function set_form_textarea($label,$column,$value,$options = []){
    $textarea = "<div class = 'form-group'>";
    $textarea .= "<label for = '$column-input' class = 'form-label'>$label</label>";
    $textarea .= "<textarea id = '$column-input' name = '$column' class = 'form-control' cols = '10' rows = '3'";
    $textarea .= isset($options['disabled']) ? " disabled " : "";
    $textarea .= ">";
    $textarea .= $value;
    $textarea .= "</textarea>";
    $textarea .= "</div>";
    return $textarea;
  }

  function set_post_form ($post = []){
    $form = "<form class = 'container form-container' action = 'comment.php' method = 'POST' autocomplete = 'off' id = 'post-".$post['id']."' >";

    $id_input = "<input type = 'hidden' name = 'id' value = '".$post['id']."' >";
    
    $user_info = "<div class = 'user-info'>";
    $user_info .= "<img src = '".MEDIA_LINK."bootstrap.png' alt = ''>";
    $user_info .= "<div>";
    $user_info .= "<small class = 'text-bold'>".$post['username']."</small>";
    $user_info .= "<br>";
    $user_info .= "<small class = 'text-muted'>".$post['posted_at']." &middot; Público";
    $user_info .= is_null($post['updated_at']) ? "" : " &middot; Editado ".time_ago($post['updated_at']);
    $user_info .= "</small>";
    $user_info .= "</div>";
    $user_info .= "</div>";

    $options = set_post_options_dropdown($post['id'],$post['options']);

    $text = "<div class = 'text-justify'>";
    $text .= "<p>".$post['text']."</p>";
    $text .= "</div>";

    $statistics = "<div>";
    $statistics .= "<small class = 'text-muted' >".$post['total_likes']." curtidas &middot; ".$post['total_comments']." comentários</small>";
    $statistics .= "</div>";

    if ($post['liked']) {
      $like_button_class = "btn btn-success";
      $like_button_text = "Curtiu";
    }else{
      $like_button_class = "btn btn-primary";
      $like_button_text = "Curtir";
    }

    $buttons = "<div class = 'input-group input-group-sm'>";
    $buttons .= "<a class = '$like_button_class' href = '".POSTS_LINK."like_post.php?id_post=".$post['id']."&redirect_url=".$_SERVER['REQUEST_URI']."'>$like_button_text</a>";
    $buttons .= "<input type = 'text' class = 'form-control' placeholder = 'Faça um comentário...' disabled >";
    $buttons .= "<button type = 'submit' class = 'btn btn-secondary' disabled>Comentar</button>";
    $buttons .= "</div>";

    $form .= $id_input;
    $form .= $options;
    $form .= $user_info;
    $form .= $text;
    $form .= $statistics;
    $form .= $buttons;
    $form .= "</form>";

    return $form;

  }

?>