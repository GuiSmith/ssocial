<?php

    session_start();

    // In /var/www/html/projects/ssocial/src/back/config.php
    define('BASE_URL', '/var/www/html/projects/ssocial/');
    define('MAIN_URL', BASE_URL . 'main/');
    define('AUTH_URL', BASE_URL . 'auth/');
    define('SRC_URL', BASE_URL . 'src/');

    define('BASE_LINK','/projects/ssocial/');
    define('MAIN_LINK', BASE_LINK . 'main/');
    define('AUTH_LINK', BASE_LINK . 'auth/');
    define('SRC_LINK', BASE_LINK . 'src/');

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

    function get_violation_message($code,$message){
        $error = [
            "column" => "pass",
            "code" => $code,
            "message" => "Erro ao inserir: $message"
        ];
        if ($code = SQLITE3_CONSTRAINT) {
            $error_message_parts = explode(' ',$message);
            $error["column"] = explode('.',$error_message_parts[count($error_message_parts)-1])[1];
            if ($error_message_parts[0] == "UNIQUE") {
                $error['message'] = array_key_exists($column,COLS) ? ucfirst(COLS[$column]." já existe!") : ucfirst("$column já existe!");
            }else{
                $error["message"] = "Violação de restrição: $error_message";
            }
        }
        return $error;
    }

    function db_conn(){
        $db = new SQLite3(SRC_URL.'back/database.sqlite',SQLITE3_OPEN_READWRITE);
        //var_dump($db);
        return $db;
    }

    function checkAuth($logged = 'either'){
        if ($logged === 'either') {
            echo "<div style = 'text-align: center' >";
                echo "<h1>Esta página está quebrada</h1>";
                echo "<a href = '".MAIN_LINK."index.php'>Clique aqui</a> para voltar ao início";
            echo "</div>";
            die();
        }
        if ($logged == true && !isset($_SESSION["user"])){
            header("Location: ".AUTH_LINK."login.php");
            exit;
        }   
        if ($logged == false && isset($_SESSION["user"])){
            header("Location: ".AUTH_LINK."my_data.php");
            exit;
        }
    }

    function get_user_by($unique_col,$col_value){
        $db = db_conn();
        $se_SQL = "SELECT * FROM users WHERE $unique_col LIKE :col_value";
        $se_query = $db->prepare($se_SQL);
        $se_query->bindValue(':col_value',$col_value,SQLITE3_TEXT);
        $se_result = $se_query->execute();
        $user = $se_result->fetchArray(SQLITE3_ASSOC);
        return $user;
    }

    function get_users(array $array = []){
        $db = db_conn();
        $se_SQL = "SELECT * FROM users";
        if (!empty($array)) {
            $se_SQL .= " WHERE ";
            $conditions = [];
            foreach ($array as $col => $values) {
                if (!empty($values)) {
                    $value_parts = explode(',',$values);
                    foreach ($value_parts as $value) {
                        $marks[] = "$col LIKE ?";
                    }
                    $conditions[] = implode(" OR ",$marks);
                }
            }
            $se_SQL .= implode(" AND ",$conditions);
        }
        echo $se_SQL;
        $se_query = $db->prepare($se_SQL);
        if (!empty($array)) {
            $i = 1;
            foreach ($array as $col => $value) {
                if (!empty($value)) {
                    foreach ($value_parts as $value) {
                        $se_query->bindValue($i,"%".ucfirst($value)."%",SQLITE3_TEXT);
                        $i++;
                    }
                }
            }
        }
        $se_result = $se_query->execute();
        $users = [];
        while ($row = $se_result->fetchArray(SQLITE3_ASSOC)) {
            $users[] = $row;
        }
        return $users;
        //var_dump($users);
    }

    function format_date($string){
        return empty($string) ? "" : date('d/m/Y H:i:s', strtotime($string));
    }

?>