<?php
session_start();

include ('../../assets/bd/conexao.php');

if (empty($_POST['email']) && empty($_POST['senha'])) {
    header('Location: ../login/login.php');
    exit;
}

$email = $_POST['email'];
$senha = $_POST['senha'];

$sql = "SELECT * FROM user WHERE email = ? and senha = ?";
$preparacao = $conn->prepare($sql);
$preparacao->bind_param('ss', $email, $senha);
$preparacao->execute();
$resultado = $preparacao->get_result();


$preparacao->execute([$email, $senha]);

// BUSCA OS DADOS E SALVA NA VARIAVEL DADOS
$usuario = $preparacao->fetch();

if ($usuario) {
    // Se o usuário for encontrado, redirecione para a página de dashboard
    header("Location: ../dashboard/hplogin.php");
    $_SESSION['user'] = $usuario['id'];
    exit;
} else {
    $_SESSION['erro_login'] = "<span class='erro'> E-mail ou senha incorretos! </span>";
    header('Location: ../login/login.php');
    exit;
}

header("Location: ../dashboard/hplogin.php ");