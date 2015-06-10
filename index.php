<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start(); // Inicia a sessão

require_once 'Forms.php';

if(isset($_POST['mes'])){
    $_SESSION['mes'] = strtoupper($_POST['mes']);
}

?>


<html>
    <head>
        <meta charset="UTF-8">
        <title>RelatoriosForms</title>
        <script src="_js/numeros.js"></script>
        <link rel="stylesheet" href="_css/geral.css">
    </head>
    <body>        
        <div id='conteudo'>
            <h2 class='htitle'>Gerenciamento de Relatórios</h2>
            <?php
            $mes = trim($_SESSION['mes']);
            
            if (!isset($_SESSION['mes']) || empty($mes)) {
                echo "<p>Favor inserir o mês no menu abaixo:</p>";
            }else{
                echo "<p>Mês Selecionado :".$_SESSION['mes']
                . "</p>";
            }
            
            
                       
            ?>
            <a id='hLink' href="index.php">Início</a>
            
            <?php
                new Forms;            
            ?>
        </div>
    </body>
</html>
