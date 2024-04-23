<?php
include ('../../assets/bd/conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Receba os dados do formulário
    $descricao = $_POST['descricao'];
    $valor = (float)$_POST['valor'];
    $data = $_POST['data'];
    $usuario_id = $_POST['usuario_id'];
    $tipo = $_POST['tipo']; // Obter o tipo de transação (positivo ou negativo)

    // Valide os dados recebidos
    if (empty($descricao) || empty($valor) || empty($data)) {
        // Responda com um erro se os dados forem inválidos
        echo json_encode(['status' => 'erro', 'mensagem' => 'Todos os campos são obrigatórios.']);
        exit;
    }

    // Modificar o valor com base no tipo de transação
    if ($tipo === 'negativo') {
        // Se o tipo é negativo, inverta o valor para negativo
        $valor = -$valor;
    }

    // Inserir a transação no banco de dados
    $sql = "INSERT INTO transacoes (descricao, valor, data, usuario_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sdsi', $descricao, $valor, $data, $usuario_id);
    // Execute a instrução preparada e insira a transação no banco de dados
    $stmt->execute();


    if ($stmt->execute()) {
        // Retornar mensagem de sucesso em JSON
        echo json_encode(['status' => 'sucesso', 'mensagem' => 'Transação adicionada com sucesso.']);
        header("Location: ../dashboard/dashboard.php");
        exit;
    } else {
        // Responder com um erro se houver falha na inserção
        echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao adicionar transação.']);
    }

    // Feche a declaração preparada
    $stmt->close();
} else {
    // Responda com um erro se a solicitação não for POST
    echo json_encode(['status' => 'erro', 'mensagem' => 'Método de solicitação inválido. Use POST.']);
}

// Feche a conexão com o banco de dados
$conn->close();
?>
<script src="../../assets/js/main.js"></script>
