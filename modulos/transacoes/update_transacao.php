<?php
session_start();
include('../../assets/bd/conexao.php');

if (isset($_POST['editar_transacao'])) {
    $transacaoId = $_POST['transacao_id'];
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];
    $data = $_POST['data'];

    $sql = "UPDATE transacoes SET descricao = ?, valor = ?, data = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sdsi', $descricao, $valor, $data, $transacaoId);
    
    if ($stmt->execute()) {
        header("Location: ../dashboard/dashboard.php");
        exit();
    } else {
        echo "Erro ao editar a transação: " . $stmt->error;
    }
} else {
    header("Location: ../dashboard/dashboard.php");
    exit();
}
?>
