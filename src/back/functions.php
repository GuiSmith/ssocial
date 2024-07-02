<?php

    function get_input($var){
        return htmlspecialchars(trim($var));
    }

    /*
    Criado por Rafael Neri
    Caminho do github: rafael-neri/validar_cpf.php
    Link de Rafael: https://gist.github.com/rafael-neri
    Link do código: https://gist.github.com/rafael-neri/ab3e58803a08cb4def059fce4e3c0e40
    Nome real da função: validaCPF(){}
    */

    function get_chars($string){
        return preg_replace( '/[^a-zA-Z]/is', '', $string );
    }

    function getCPF($cpf){
        return preg_replace( '/[^0-9]/is', '', $cpf );
    }
    function checkCPF($cpf) {
 
        // Extrai somente os números
        $cpf = getCPF($cpf);
         
        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }
    
        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }
    
        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
    
    }

?>