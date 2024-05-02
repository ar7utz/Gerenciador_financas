<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login - Gerenciador de Finanças</title>
        <link rel="stylesheet" href="../../assets/css/style.css">
    </head>
    <body>
        <a class="btn_voltar_cad" href="../../index.php">Voltar</a>

        <form action="logon.php" method="POST" class="form_login">
            <div class="pageTitle">
                <h1>LOGIN</h1>
            </div>
            <div class="email">
                <input type="text" placeholder="Email" name="email" autocomplete="off" required>
            </div>
            <div class="password">
                <input type="password" placeholder="Senha" name="senha" required>
            </div>
            <div>
                <input type="submit" value="Login">
            </div>
        </form>

        <?php
            // Verifica se a mensagem de erro está definida na variável de sessão
            if (isset($_SESSION['erro_login'])) {
            echo '<p style="color: red;">' . $_SESSION['erro_login'] . '</p>';
            unset($_SESSION['erro_login']); // Remove a mensagem de erro após exibi-la
            }
        ?>

    </body>
</html>