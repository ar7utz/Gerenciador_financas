<?php
    include_once "../../config.php";
?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login - Gerenciador de Finanças</title>
    </head>
    <body>
        <form action="dashboard.php" method="POST">

            <label for="login">Login</label>
            <input type="text" name="login">
            
            <label for="senha">Senha</label>
            <input type="text" name="senha">

            <input type="submit" value="Login">
        </form>
    </body>
</html>