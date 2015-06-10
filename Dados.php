<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Dados
 *
 * @author Tiagop
 */
class Dados {
    //put your code here
    
    public static function buscar($banco,$query) {            
        $host = "localhost";
        $user = "root";
        $pass = "usbw";
        //$banco = "cadastro";
        $conexao = mysql_connect($host, $user,$pass) or die(mysql_error());
        mysql_select_db($banco, $conexao) or die(mysql_error());        
        $sql = mysql_query($query) or die (mysql_error());        
        return $sql;        
    }
    
}
