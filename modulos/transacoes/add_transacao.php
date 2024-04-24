<?php
include ('../../assets/bd/conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $descricao = $_POST['descricao'];
    $valor = (float)$_POST['valor'];
    $data = $_POST['data'];
    $usuario_id = $_POST['usuario_id'];
    $tipo = $_POST['tipo']; // Obter o tipo de transação (positivo ou negativo)

    if (empty($descricao) || empty($valor) || empty($data)) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Todos os campos são obrigatórios.']);
        exit;
    }

    if ($tipo === 'negativo') {
        $valor = -$valor;
    }

    $sql = "INSERT INTO transacoes (descricao, valor, data, usuario_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sdsi', $descricao, $valor, $data, $usuario_id);
    $stmt->execute();


    if ($stmt->execute()) {
        echo json_encode(['status' => 'sucesso', 'mensagem' => 'Transação adicionada com sucesso.']);
        header("Location: ../dashboard/dashboard.php");
        exit;
    } else {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao adicionar transação.']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Método de solicitação inválido. Use POST.']);
}

$conn->close();
?>
<script src="../../assets/js/main.js"></script>
