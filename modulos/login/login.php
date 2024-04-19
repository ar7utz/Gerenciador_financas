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
        <form action="dashboard.php" method="POST">

            <input type="text" placeholder="username" name="login">
            
            <input type="password" placeholder="name" name="senha">

            <input type="submit" value="Login">
        </form>

    </body>
</html>