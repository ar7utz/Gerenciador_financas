<?php
session_start();

include ('../../assets/bd/conexao.php');

if (empty($_POST['email']) && empty($_POST['senha'])) {
    header('Location: ../login/login.php');
    exit;
}

$email = $_POST['email'];
$senha = $_POST['senha'];
// CRIA A SQL PARA EXECUTAR NO BANCO DE DADOS
$sql = "SELECT * FROM user WHERE email = ? and senha = ?";
$preparacao = $conn->prepare($sql);
$preparacao->bind_param('ss', $email, $senha);
$preparacao->execute();
$resultado = $preparacao->get_result();

// FALANDO PRO BANCO QUAL SQL VAMOS EXECUTAR
$preparacao->execute([$email, $senha]);

// BUSCA OS DADOS E SALVA NA VARIAVEL DADOS
$usuario = $preparacao->fetch();

if ($usuario) {
    // Se o usuário for encontrado, redirecione para a página de dashboard
    header("Location: ../dashboard/hplogin.php");
    $_SESSION['user'] = $usuario['id'];
    exit;
} else {
    // Se o usuário não for encontrado, redirecione de volta para a página de login com uma mensagem de erro
    $_SESSION['erro_login'] = "<span class='erro'> E-mail ou senha incorretos! </span>";
    header('Location: ../login/login.php');
    exit;
}

header("Location: ../dashboard/hplogin.php ");