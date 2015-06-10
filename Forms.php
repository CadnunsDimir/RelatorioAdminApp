<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Forms
 *
 * @author Tiagop
 */

require_once "Dados.php";

class Forms {
    static $num2 = null;
    static $livros2 = null;
    static $brochuras2 = null;
    static $horas2 = null;
    static $revistas2 = null;
    static $revisitas2 = null;
    static $estudos2 = null;   
    static $banco = 'relatorios';
    
    function __construct() {
        
        if(!isset($_GET['funcao'])){
            $this->indice();
        }else switch ($_GET['funcao']) {
                case 'insert': $this->insereRelatorio();
                    break; 
                case 'all': $this->showTable();
                    break; 
                case 'total': $this->parcial();
                    break; 
                case 'final': $this->relatorioFinal();
                    break; 
                case 'setMes': $this->setMes();
                    break; 
                default: echo 'not found function '.$_GET['funcao'];
                    break;
            }
        }
    
    public static function setMes(){
        Forms::indice();
        echo 
        "<form id='fRel' name='signup' method='post' action='index.php'>"
        . "<p>Digite o mes abaixo</p>"                
                . "<input class='border' type='text' name='mes'/>"
                . "<input class='sb' type='submit'/>"
        . "</form>";
    }

    public static function indice(){
        echo 
        "<form id='fRel' class='underline' name='signup' method='get' action='index.php'>"
        . "<h4>Menu</h4><select class='border' name='funcao'>"
                        . "<option class='border' value='insert'>Inserir novo relatorio</option>"
                        . "<option class='border' value='all'>Ver todos os relatórios de ".$_SESSION['mes']."</option>"                   
                        . "<option class='border' value='final'>Relatorio Final de ".$_SESSION['mes']."</option>"
                        . "<option class='border' value='total'>totais gerais ".$_SESSION['mes']."</option>"
                        . "<option class='border' value='setMes'>Alterar Mês</option>"
                . "</select>"
                . "<input class='sb' type='submit'/>"
        . "</form>";
         
    }
    
    public static function insereRelatorio(){
        Forms::indice();        
        echo "<form id='fRel' name='signup' method='post' action='processing.php'>";        
        echo "<h3>Inserindo um novo relatório</h3>";
        echo "<table>";
        echo "<tr><td>Nome</td><td>Livros</td><td>Brochuras</td><td>Horas</td><td>Revistas</td><td>Revisitas</td><td>Estudos</td><td>Categoria</td></tr>";
        echo "<tr><td><input class='border' type='text' name='nome'/></td>"
                . "<td><input class='num border' type='text' name='livros' onkeypress='return apenasNumeros(event)'></td>"
                . "<td><input class='num border' type='text' name='brochuras' onkeypress='return apenasNumeros(event)'></td>"
                . "<td><input class='num border' type='text' name='horas' onkeypress='return apenasNumeros(event)'></td>"
                . "<td><input class='num border' type='text' name='revistas' onkeypress='return apenasNumeros(event)'></td>"
                . "<td><input class='num border' type='text' name='revisitas' onkeypress='return apenasNumeros(event)'></td>"
                . "<td><input class='num border' type='text' name='estudos' onkeypress='return apenasNumeros(event)'></td>"
                    . "<td><select class='border' name='cat'>"
                        . "<option class='border' value='PR'>Regular, Pioneiro</option>"
                        . "<option value='PA'>Auxiliar, Pioneiro</option>"
                        . "<option value='PU'>Publicador</option>"
                    . "</select>"
                . "</td>"
                . "</tr>";
        echo "</table>";
        echo "<input class='sb' type='submit'/>";
        echo "</form>";
    }
    
    public static function showTable(){        
        $mes = $_SESSION['mes'];
        Forms::indice();
        $mes = strtoupper($mes);        
        $sql = Dados::buscar(Forms::$banco, "select * from $mes");
        echo "<h3>Todos os Relatórios de $mes</h3>";
        Forms::formTable($sql,"Todos os Publicadores", true);        
    }
    
    private static function formTable($sql,$titulo,$mostraCat = false){
        
        $livros = null;
        $brochuras = null;
        $horas = null;
        $revistas = null;
        $revisitas = null;
        $estudos = null;
        
        
        echo "<table class='tab' >";
        echo "<caption>$titulo</caption>";
        echo "<tr><th>Nome</th><th>Livros</th><th>Brochuras</th><th>Horas</th><th>Revistas</th><th>Revisitas</th><th>Estudos</th>";
        echo ($mostraCat)? "<th>Categoria</th>" :"";
        echo "</tr>";
        while($escrever = mysql_fetch_array($sql)){
                echo "<tr><td>"
                        .$escrever['nome']."</td><td>"
                        .$escrever['livros']."</td><td>"                        
                        .$escrever['brochuras']."</td><td>"
                        .$escrever['horas']."</td><td>"
                        .$escrever['revistas']."</td><td>"
                        .$escrever['revisitas']."</td><td>"
                        .$escrever['estudos']."</td>";
                echo ($mostraCat)? "<td>".$escrever['cat']."</td>" :"";
                echo "</tr>";
                $livros += intval($escrever['livros']);
                $brochuras += intval($escrever['brochuras']);
                $horas += intval($escrever['horas']);
                $revistas += intval($escrever['revistas']);
                $revisitas += intval($escrever['revisitas']);
                $estudos += intval($escrever['estudos']);
            }
            
            //Agora  a soma dos elementos
        echo "<tr>";         
        $num = mysql_num_rows($sql);
        echo "<th>$num Publicador(es)</th><th>$livros</th><th>$brochuras</th><th>$horas</th><th>$revistas</th><th>$revisitas</th><th>$estudos</th>";
        echo ($mostraCat)? "<th>##</th>" :"";
        echo "</tr>";
        echo '</table>';
        
        
    }
    
    private static function linhaSoma($sql,$categoria){
        $livros = null;
        $brochuras = null;
        $horas = null;
        $revistas = null;
        $revisitas = null;
        $estudos = null;
        while($escrever = mysql_fetch_array($sql)){
                $livros += intval($escrever['livros']);
                $brochuras += intval($escrever['brochuras']);
                $horas += intval($escrever['horas']);
                $revistas += intval($escrever['revistas']);
                $revisitas += intval($escrever['revisitas']);
                $estudos += intval($escrever['estudos']);
            }
            
            //Agora  a soma dos elementos
        echo "<tr>";         
        $num = mysql_num_rows($sql);
        echo "<td>$categoria</td><td>$num</td><td>$livros</td><td>$brochuras</td><td>$horas</td><td>$revistas</td><td>$revisitas</td><td>$estudos</td></tr>";
        echo "</tr>";
        static::$num2 += $num;
        static::$livros2 += $livros;
        static::$brochuras2 += $brochuras;
        static::$horas2 += $horas;
        static::$revistas2 += $revistas;
        static::$revisitas2 += $revisitas;
        static::$estudos2 += $estudos;
         
    }
    
    private static function parcial(){
        $mes = strtoupper($_SESSION['mes']);
        Forms::indice();  
        echo "<h3>Totais parciais do Mês de $mes</h3>";        
        $banco = Forms::$banco;
        $mes = strtoupper($mes);
        
        $sql1 = Dados::buscar($banco, "select * from $mes where cat='PR'");
        $sql2 = Dados::buscar($banco, "select * from $mes where cat='PA'");
        $sql3 = Dados::buscar($banco, "select * from $mes where cat='PU'");
        
        echo "<table class='tab'>";
        echo "<tr><th>Categoria</th><th>Totais</th><th>Livros</th><th>Brochuras</th><th>Horas</th><th>Revistas</th><th>Revisitas</th><th>Estudos</th></tr>";
        Forms::linhaSoma($sql1, 'Regulares');
        Forms::linhaSoma($sql2, 'Auxiliares');
        Forms::linhaSoma($sql3, 'Publicadores');
        echo "<th>Totais</th><th>"
        .Forms::$num2."</th><th>"
                .Forms::$livros2. "</th><th>"
                .Forms::$brochuras2."</th><th>"
                .Forms::$horas2."</th><th>"
                .Forms::$revistas2."</th><th>"
                .Forms::$revisitas2."</th><th>"
                .Forms::$estudos2."</th></tr>";
        echo "<table>";
        
    }

    public static function relatorioFinal(){
        /*mostra um Relatorio final
         * com o mes no topo
         * com tres tabelas
         * 1- com tres linhas e seus respctivos totais
         *      a)publicadores
         *      b)auxiliares
         *      c)regulares
         *  e mais uma com os totais
         * 
         * 2- uma com os registros dos pioneiros regulares(se houver) 
         *      e os totais
         * 3- uma com os registros dos poineiros auxiliares(se houver);
         *      e os totais
         */
        $mes = strtoupper($_SESSION['mes']);
        echo "<h3>Relatórios Geral da Congregação no Mês de $mes</h3>";
        $banco = Forms::$banco;
        $mes = strtolower($mes);
        
        $sql1 = Dados::buscar($banco, "select * from $mes where cat='PR'");
        $sql2 = Dados::buscar($banco, "select * from $mes where cat='PA'");
        $sql3 = Dados::buscar($banco, "select * from $mes where cat='PU'");
        
        echo "<table class='tab'>";
        echo "<tr><th>Categoria</th><th>Totais</th><th>Livros</th><th>Brochuras</th><th>Horas</th><th>Revistas</th><th>Revisitas</th><th>Estudos</th></tr>";
        Forms::linhaSoma($sql1, 'Regulares');
        Forms::linhaSoma($sql2, 'Auxiliares');
        Forms::linhaSoma($sql3, 'Publicadores');
        echo "<th>Totais</th><th>"
        .Forms::$num2."</th><th>"
                .Forms::$livros2. "</th><th>"
                .Forms::$brochuras2."</th><th>"
                .Forms::$horas2."</th><th>"
                .Forms::$revistas2."</th><th>"
                .Forms::$revisitas2."</th><th>"
                .Forms::$estudos2."</th></tr>";
        echo "<table>";
        
        $sql1 = Dados::buscar($banco, "select * from $mes where cat='PR'");
        $sql2 = Dados::buscar($banco, "select * from $mes where cat='PA'");
        Forms::formTable($sql1, "Pioneiros Regulares");
        Forms::formTable($sql2, "Pioneiros Auxiliares");        
        
    }
}
