<meta charset="utf-8">
<a href="index.php" align="center">Início</a>

<?php
session_start(); // Inicia a sessão
$mes =  $_SESSION['mes'];
$nome = strtoupper($_POST['nome']);
$livros = $_POST['livros'] + 0;
$brochuras =  $_POST['brochuras']+ 0;
$horas = $_POST['horas']+ 0;
$revistas =  $_POST['revistas']+ 0;
$revisitas =  $_POST['revisitas']+ 0;
$estudos =  $_POST['estudos']+ 0;
$cat =  $_POST['cat'];
require_once 'Dados.php';
$query = "CREATE TABLE IF NOT EXISTS `$mes`("
        . "id int(4) AUTO_INCREMENT,"
        . "nome varchar(20),"
        . "livros int(3),"
        . "brochuras int(3),"
        . "horas int(3),"
        . "revistas int(3),"
        . "revisitas int(3),"
        . "estudos int(3),"
        . "cat varchar(2),"
        . "PRIMARY KEY(id)"
        . ")";

Dados::buscar("relatorios", $query);

$query = "INSERT INTO  `$mes` (nome, livros, brochuras, horas, revistas, revisitas, estudos, cat) "
        . "VALUES ('$nome',$livros, $brochuras, $horas, $revistas, $revisitas, $estudos, '$cat')";
Dados::buscar("relatorios", $query);
unset($_POST);
echo "<script>window.location.href='index.php?funcao=insert';"
. "alert('inserida nova linha');</script>";
//sleep(3);
//header("Location: index.php?funcao=insert");
