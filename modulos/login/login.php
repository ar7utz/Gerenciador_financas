<?php
    include_once "../../config.php";
?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login - Gerenciador de Finanças</title>
        <link rel="stylesheet" href="../../assets/css/style.css">
    </head>
    <body>
        <h1>LOGIN</h1>
        <form action="<?=arquivo('../../modulos/login/login.php')?>" method="POST">

            <input type="text" placeholder="email" name="email" autocomplete="off" required>
            
            <input type="password" placeholder="senha" name="senha" required>

            <input type="submit" value="Login">
        </form>

    </body>
</html>