<?php 
$host = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'pit';

$con = new mysqli($host, $usuario, $senha, $banco);

if(mysqli_connect_errno()){
    exit("Erro ao concetar-se ao banco de dados. ".mysqli_connect_error());
}

?>