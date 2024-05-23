<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Conecta ao banco de dados
    $conn = new mysqli('host', 'usuario', 'senha', 'dbname');
    
    // Verifica a conexão
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    $nome = $conn->real_escape_string($_POST['nome']);
    $email = $conn->real_escape_string($_POST['email']);
    $telefone = $conn->real_escape_string($_POST['telefone']);
    $profile_picture = $_FILES['profile_picture'];

    // Processa o upload da imagem
    if ($profile_picture['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($profile_picture["name"]);
        move_uploaded_file($profile_picture["tmp_name"], $target_file);
    }

    // Atualiza os dados no banco de dados
    $user_id = $_SESSION['id'];
    $sql = "UPDATE users SET nome='$nome', email='$email', telefone='$telefone'";
    if ($profile_picture['error'] == 0) {
        $sql .= ", profile_picture='$target_file'";
    }
    $sql .= " WHERE id='$user_id'";

    if ($conn->query($sql) === TRUE) {
        // Atualiza as informações na sessão
        $_SESSION['nome'] = $nome;
        $_SESSION['email'] = $email;
        $_SESSION['telefone'] = $telefone;
        
        // Redireciona ou exibe uma mensagem de sucesso
        header("Location: profile.php");
        exit();
    } else {
        echo "Erro ao atualizar perfil: " . $conn->error;
    }

    // Fecha a conexão
    $conn->close();
}
?>
