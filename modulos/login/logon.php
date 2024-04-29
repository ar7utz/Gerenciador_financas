<?php
session_start();

include ('../../assets/bd/conexao.php');

if (empty($_POST['email']) && empty($_POST['senha'])) {
    header('Location: ../login/login.php');
    exit;
}

$email = $_POST['email'];
$senha = $_POST['senha'];

$sql = "SELECT id FROM user WHERE email = ? and senha = ?";
$preparacao = $conn->prepare($sql);
$preparacao->bind_param('ss', $email, $senha);
$preparacao->execute();
$resultado = $preparacao->get_result();


$preparacao->execute([$email, $senha]);

// BUSCA OS DADOS E SALVA NA VARIAVEL DADOS
$usuario = $preparacao->fetch();

if ($resultado->num_rows > 0) {
    $usuario = $resultado->fetch_assoc();

    $_SESSION['id'] = $usuario['id'];
    header("Location: ../dashboard/hplogin.php");
    exit;
} else {
    $_SESSION['erro_login'] = "<span class='erro'> E-mail ou senha incorretos! </span>";
    header('Location: ../login/login.php');
    exit;
}

header("Location: ../dashboard/hplogin.php ");