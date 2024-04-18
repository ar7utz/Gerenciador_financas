<?php
session_start();

include '../bd/conexao.php';

if (empty($_POST['email']) && empty($_POST['senha'])) {
    header('Location: login.php');
    exit;
}

$email = $_POST['email'];
$senha = $_POST['senha'];
// CRIA A SQL PARA EXECUTAR NO BANCO DE DADOS
$sql = "SELECT * FROM user WHERE email = ? and senha = ?";

$preparacao = $conexaoBanco->prepare($sql);

// FALANDO PRO BANCO QUAL SQL VAMOS EXECUTAR
$preparacao->execute([$email, $senha]);

// BUSCA OS DADOS E SALVA NA VARIAVEL DADOS
$usuario = $preparacao->fetch();

$_SESSION['user'] = $usuario['id'];

header("Location: ../index.php ");