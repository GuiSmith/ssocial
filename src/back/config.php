<?php

    session_start();

    function myErrorHandler($errno, $errstr, $errfile, $errline) {
        global $php_error_message;
        if (strpos($errstr, 'attempt to write a readonly ') !== false) {
            // Encaminha usuário para a tela que explica o erro de somente leitura do banco de dados
            header("Location: /ssocial/readonly_error.php");
        } else {
            // Exibe outros erros normalmente
            $php_error_message = "Erro: [$errno] $errstr - $errfile:$errline";
        }
    
        // Não executa o manipulador interno de erros do PHP
        return true;
    }
    
    // Configura o manipulador de erros personalizado
    set_error_handler("myErrorHandler");


    define('BASE_URL', '/var/www/html/ssocial/');
    define('MAIN_URL', BASE_URL . 'main/');
    define('SRC_URL', BASE_URL . 'src/');
    define('MEDIA_URL', BASE_URL . 'media/');
    define('USERS_URL', BASE_URL . 'users/');
    define('POSTS_URL', BASE_URL . 'posts/');
    define('ADM_URL', BASE_URL . 'adm/');

    define('BASE_LINK','/ssocial/');
    define('MAIN_LINK', BASE_LINK . 'main/');
    define('SRC_LINK', BASE_LINK . 'src/');
    define('MEDIA_LINK', BASE_LINK . 'media/');
    define('USERS_LINK', BASE_LINK . 'users/');
    define('POSTS_LINK', BASE_LINK . 'posts/');
    define('ADM_LINK', BASE_LINK . 'adm/');
    define('TABLE_MAX_LINES', 15);

    if (!defined("SQLITE3_CONSTRAINT")) {
        define("SQLITE3_CONSTRAINT",19);
    }
    define('COLS', [
        "username" => "nome",
        "email" => "e-mail",
        "cpf" => "CPF",
        "pass" => "senha",
        "created_at" => "data criação",
        "updated_at" => "data atualização"
    ]);
    define('ERROR_UNIQUE','UNIQUE');
    
    //Returns a sanitized a file name
    function sanitize_filename($filename) {
        // Remove any special characters except for hyphens, underscores, and periods
        $filename = preg_replace('/[^A-Za-z0-9\-_\.]/', '', $filename);
    
        // Remove any sequences of periods or special characters to avoid directory traversal
        $filename = preg_replace('/(\.{2,})/', '', $filename);
    
        // Trim the filename to a reasonable length
        $filename = substr($filename, 0, 255);
    
        // Remove leading and trailing spaces, and convert special characters to HTML entities
        $filename = htmlspecialchars(trim($filename));
    
        return $filename;
    }

    //Returns an unique file directory/filename.extension
    function get_unique_filename($directory, $filename) {
        $unique_id = uniqid();
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $basename = pathinfo($filename, PATHINFO_FILENAME);
        $sanitized_basename = sanitize_filename($basename);
        return $directory . $sanitized_basename . '_' . $unique_id . '.' . $extension;
    }

    //Uploads an image based on the user id, directory (either profile picture, post or comment) and file itself
    function upload_image(int $id_user,string $folder_name,array $file_array){
        if (empty($file_array) || !isset($file_array['tmp_name']) || !file_exists($file_array['tmp_name'])) {
            var_dump($file_array);
            return "No image was sent to be processed";
        }

        $image_dir = MEDIA_URL."users/$id_user/$folder_name/";
        $feedback = [];
        $ok = true;

        if (!is_dir($image_dir)) {
            mkdir($image_dir,0777,true);
            //$feedback['folder'] = "Image folder created!";
        }else{
            //$feedback['folder'] = "Didn't have to create an image folder because it already exists!";
        }

        // Get the uploaded file information
        $target_file = get_unique_filename($image_dir,basename($file_array["name"]));
        $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if the file is an actual image or fake image
        $check = getimagesize($file_array["tmp_name"]);
        if ($check === false) {
            $feedback['type'] = "File is not an image!";
            $ok = false;
        }else{
            unset($feedback['file_type']);
        }

        // Check file size (5MB limit)
        if ($file_array["size"] > 5000000) {
            $feedback['size'] = "Image size is too big, chose a smaller one";
            $ok = false;
        }else{
            unset($feedback['size']);
        }

        // Allow certain file formats
        $allowed_formats = ["jpg", "jpeg", "png", "gif"];
        if (!in_array($image_file_type, $allowed_formats)) {
            $feedback['image_type'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $ok = false;
        }else{
            unset($feedback['image_type']);
        }

        // Attempt to move the uploaded file to the target directory
        if ($ok) {
            if (move_uploaded_file($file_array["tmp_name"], $target_file)) {
                $feedback['upload'] = "File has been successfully uploaded";
                $file_name = basename($target_file);
                return [
                    'ok' => true,
                    'feedback' => implode("<br>",$feedback),
                    'image_src' => "http://localhost/ssocial/media/users/$id_user/$folder_name/$file_name"
            ];
            }else{
                $feedback['upload'] = "Sorry, there was an error uploading your file.";
            }
        }else{
            $feedback['upload'] = "File was not uploaded because of dependencies.";
        }
        
        return ['ok' => false,'feedback' => implode("<br>",$feedback)];
    }

    //Calculates the amount of pages based on rows count and table's max lines
    function getTablePages($sql){
        $db = db_conn();
        $lines = $db->querySingle("SELECT COUNT(created_at) AS lines FROM ($sql)");
        if ($lines <= TABLE_MAX_LINES) {
            $pages = 0;
        }else{
            //Strip last page lines
            $last_page_lines = $lines%TABLE_MAX_LINES;
            //Calculate pages count
            if ($last_page_lines > 0) {
                //If rows count is exactly divisible by the defined max lines
                //Also add one more page
                $pages = (($lines-$last_page_lines)/TABLE_MAX_LINES) + 1;
            }else{
                //If rows count is exactly divisible by the defined max lines
                $pages = $lines/TABLE_MAX_LINES;
            }
            $pages_array = [];

            //var_dump("$pages and a last page with $last_page_lines lines");
        }
        return $pages;
    }
    
    //Consulta de postagens
    function get_posts(array $array = [], $single = false){
        $db = db_conn();
        $se_SQL = "SELECT * FROM post";
        if (!empty($array)) {
            $se_SQL .= " WHERE ";
            $conditions = [];
            foreach ($array as $col => $values) {
                $value_parts = explode(',',$values);
                foreach ($value_parts as $value) {
                    $marks[] = "$col LIKE ?";
                }
                $conditions[] = implode(" OR ",$marks);
            }
            $se_SQL .= implode(" AND ",$conditions);
        }
        //echo $se_SQL;
        $se_query = $db->prepare($se_SQL);
        if (!empty($array)) {
            $i = 1;
            foreach ($array as $col => $value) {
                foreach ($value_parts as $value) {
                    $se_query->bindValue($i,"%".trim(ucfirst($value))."%",SQLITE3_TEXT);
                    $i++;
                }
            }
        }
        $se_result = $se_query->execute();
        $posts = [];
        while ($row = $se_result->fetchArray(SQLITE3_ASSOC)) {
            $row['options'] = [
                ['text' => 'Visualizar','path' => POSTS_LINK.'crud/view_post.php']
            ];
            if (logged()) {
                if ($row['id_user'] == $_SESSION['user']['id']) {
                    $row['options'][] = ['text' => 'Editar','path' => POSTS_LINK.'crud/edit_post.php'];
                    $row['options'][] = ['text' => 'Deletar','path' => POSTS_LINK.'crud/delete_post.php'];
                }
                //Se usuário autenticado já curtiu o post
                if ($db->querySingle("SELECT created_at FROM post_likes WHERE id_user = ".$_SESSION['user']['id']." AND id_post = ".$row['id']) == null) {
                    $row['liked'] = false;
                }else{
                    $row['liked'] = true;
                }
            }else{
                $row['liked'] = false;
            }
            $row['posted_at'] = time_ago($row['created_at']);
            $row['image_src'] = $row['image_src'] == null ? 'http://localhost/ssocial/media/std_pfp.png' : $row['image_src'];
            $posts[] = $row;
        }
        return $single ? $posts[0] : $posts;
    }

    //Retorna a diferença de tempo entre uma data e agora no formato de texto simplificado
    function time_ago($datetime) {
        // Create a DateTime object for the current time in the local timezone
        $now = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));

        // Create a DateTime object for the provided time in UTC
        $post_time = new DateTime($datetime, new DateTimeZone('UTC'));

        // Convert the post time to the local timezone
        $post_time->setTimezone(new DateTimeZone('America/Sao_Paulo'));

        // Calculate the difference between the current time and the post time
        $interval = $now->diff($post_time);

        $seconds = $interval->s;
        $minutes = $interval->i;
        $hours = $interval->h;
        $days = $interval->d;
        $weeks = floor($interval->days / 7);
        $months = $interval->m + ($interval->y * 12);
        $years = $interval->y;

        if ($years > 0) {
            return $years == 1 ? "1 ano" : "$years anos";
        }
        if ($months > 0) {
            return $months == 1 ? "1 mês" : "$months meses";
        }
        if ($weeks > 0) {
            return $weeks == 1 ? "1 semana" : "$weeks semanas";
        }
        if ($days > 0) {
            return $days == 1 ? "ontem" : "$days dias";
        }
        if ($hours > 0) {
            return $hours."h";
        }
        if ($minutes > 0) {
            return $minutes."min";
        }
        if ($seconds > 0) {
            return $seconds."s";
        }
        return "Agora";
    }

    //Retorna true se o número passado for inteiro e positivo
    function is_natural($number){
        return is_numeric($number) && $number > 0;
    }

    //Formata data de formato string (sqlite3) para data (Brasil)
    function format_date($date_string){
        return $date_string != null ? date('d/m/Y H:i:s',strtotime($date_string)) : "";
    }

    //Retorna true se o usuário atual estiver autenticado - status de autenticação
    function logged(){
        return isset($_SESSION['user']);
    }
    
    //Retorna uma mensagem humana de erro de violação de constraint do banco de dados
    function get_violation_message($code,$message){
        $error = [
            "column" => "pass",
            "message" => "Erro ao inserir: $message"
        ];
        if ($code = SQLITE3_CONSTRAINT) {
            $error_message_parts = explode(' ',$message);
            if ($error_message_parts[0] == "UNIQUE") {
                $column = explode('.',$error_message_parts[count($error_message_parts)-1])[1];
                $error["column"] = $column;
                if (array_key_exists($column,COLS)) {
                    $error["message"] = ucfirst(COLS[$column]." já existe!");
                }else{
                    $error["message"] = ucfirst("$column já existe!");
                }
            }else{
                $error["message"] = "Violação de restrição: $error_message";
            }
        }
        return $error;
    }

    //Retorna a conexão com banco de dados
    function db_conn(){
        $db = new SQLite3(SRC_URL.'back/database.sqlite',SQLITE3_OPEN_READWRITE);
        //var_dump($db);
        return $db;
    }

    function checkAuth($logged = 'either', $adm = false){
        if ($logged === 'either') {
            echo "<div style = 'text-align: center' >";
                echo "<h1>Esta página está quebrada</h1>";
                echo "<a href = '".MAIN_LINK."index.php'>Clique aqui</a> para voltar ao início";
            echo "</div>";
            die();
        }
        if ($logged == true && !logged()){
            header("Location: ".USERS_LINK."auth/login.php");
            exit;
        }   
        if ($logged == false && logged()){
            header("Location: ".USERS_LINK."profile.php");
            exit;
        }
        if ($logged == true & $adm == true) {
            if (!isset($_SESSION['user']['adm']) || !$_SESSION['user']['adm']) {
                header("Location: ".USERS_LINK."profile.php");
                exit;
            }
        }
    }

    //Buscar dados de um usuário com coluna única (ID, email ou cpf)
    function get_user_by($unique_col,$col_value){
        $db = db_conn();
        $se_SQL = "SELECT * FROM users WHERE $unique_col LIKE :col_value";
        $se_query = $db->prepare($se_SQL);
        $se_query->bindValue(':col_value',$col_value,SQLITE3_TEXT);
        $se_result = $se_query->execute();
        $user = $se_result->fetchArray(SQLITE3_ASSOC);
        return $user;
    }

    //Consulta de usuários
    function get_users(array $array = [], $single = false){
        $db = db_conn();
        $se_SQL = "SELECT * FROM users";
        if (!empty($array)) {
            $se_SQL .= " WHERE ";
            $conditions = [];
            foreach ($array as $col => $values) {
                if (!empty($values)) {
                    $value_parts = explode(',',$values);
                    foreach ($value_parts as $value) {
                        $marks[] = str_contains($col,"id") ? "$col = ?" : "$col LIKE ?";
                    }
                    $conditions[] = implode(" OR ",$marks);
                }
            }
            $se_SQL .= implode(" AND ",$conditions);
        }
        //echo $se_SQL;
        $se_query = $db->prepare($se_SQL);
        if (!empty($array)) {
            $i = 1;
            foreach ($array as $col => $value) {
                if (!empty($value)) {
                    foreach ($value_parts as $value) {
                        if (str_contains($col,"id")) {
                            $se_query->bindValue($i,trim($value),SQLITE3_INTEGER);
                        }else{
                            $se_query->bindValue($i,"%".trim(ucfirst($value))."%",SQLITE3_TEXT);
                        }
                        $i++;
                    }
                }
            }
        }
        $se_result = $se_query->execute();
        $users = [];
        while ($row = $se_result->fetchArray(SQLITE3_ASSOC)) {
            if (logged()) {
                $users_follow = $db->querySingle("SELECT * FROM users_follow WHERE id_user_follower = ".$_SESSION['user']['id']." AND id_user_followed = ".$row['id'], true);
                if (!empty($users_follow) && $users_follow['active'] == 1) {
                    $row['following'] = true;
                    $row['followed_first_at'] = format_date($users_follow['created_at']);
                    $row['following_since'] = $users_follow['updated_at'] == null ? format_date($users_follow['created_at']) : format_date($users_follow['updated_at']);               
                }else{
                    $row['following'] = false;
                    $row['followed_first_at'] = "";
                    $row['following_since'] = "";
                }
            }else{
                $row['following'] = false;
                $row['followed_first_at'] = "";
                $row['following_since'] = "";
            }
            $row['image_src'] = $row['image_src'] == NULL ? 'http://localhost/ssocial/media/std_pfp.png' : $row['image_src'];
            $users[] = $row;
        }
        return $single ? $users[0] : $users;
        //var_dump($users);
    }
?>