<?php
$host = 'localhost';
$dbname = 'bd_gffa';
$usuario = 'root';
$senha = '';

// Criar uma conexão com o banco de dados
$conn = new mysqli($host, $usuario, $senha, $dbname);

// Verificar se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die('Erro de conexão: ' . $conn->connect_error);
}
?>