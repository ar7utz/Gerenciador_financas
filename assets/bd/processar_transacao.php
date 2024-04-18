<?php
// Configurações do banco de dados
$host = 'localhost';
$dbname = 'bd_gffa';
$username = 'root';
$password = '';

// Conecta ao banco de dados
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Falha na conexão com o banco de dados: " . $e->getMessage();
    exit();
}

// Verifica se os dados foram enviados
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];
    $data = $_POST['data'];

    // Insere os dados na tabela de transações
    $sql = "INSERT INTO transacoes (descricao, valor, data) VALUES (:descricao, :valor, :data)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':valor', $valor);
    $stmt->bindParam(':data', $data);

    // Execute a inserção
    if ($stmt->execute()) {
        echo "Transação salva com sucesso!";
    } else {
        echo "Erro ao salvar a transação.";
    }
}
?>
