<?php
session_start();

include ('../../assets/bd/conexao.php');

$id = $_SESSION['id'];

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Redireciona para a página de perfil
    header("Location: perfil.php");
    exit();
}


$sql = "SELECT * FROM user WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$resultado = $stmt->get_result();

if($resultado->num_rows > 0) {
    $usuario = $resultado->fetch_assoc();
} else {
    echo "Usuário não encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/scrollbar.css">
    <link rel="shortcut icon" href="../../dinheiro.ico"/>
    <title>Meu Perfil - Gerenciador de Finanças</title>
</head>
<body>
    <div class="nav_top">
        <a class="btn_sair" href="../login/logout.php">Sair</a>
        <a class="btn_voltar" href="../dashboard/dashboard.php">Voltar</a>
    </div>
    <h1 class="pageTitle">Meu Perfil</h1>
    <div class="container_perfil">
        <div class="img_perfil">
            <img src="path/to/default/image.jpg" alt="Foto de Perfil">
            <input type="file" name="profile_picture" accept="image/*">
        </div>
        <!--divisão-->
        <div class="infos">
            <form action="../usuario/atualizarPerfil.php" method="post" enctype="multipart/form-data">
                <div>
                    <label for="NomeCompleto">Nome:</label>
                    <input type="text" id="NomeCompleto" name="nome" value="<?php echo $user['nome']; ?>" >
                </div>
                <div class="email">
                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email">
                </div>
                <div class="telefone">
                    <label for="telefone">Telefone:</label>
                    <input type="tel" id="telefone" name="telefone">
                </div>
                    <button type="submit" class="btn_salvarAlt">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>