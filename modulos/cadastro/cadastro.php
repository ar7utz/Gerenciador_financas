<?php
    include_once "../../config.php";
?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../assets/css/style.css">
        <title>Cadastro de Usuário</title>
    </head>
    <body>
        <form action="login.php" method="POST" name="cadastro">
            <div class="pageTitle">
            <h1>Cadastro de Usuário</h1>
            </div>
            
            <label for="NomeCompleto">Insira seu Nome Completo</label>
            <input type="text" placeholder="Nome">

            <div class="email">
                <label for="email">E-mail</label>
                <input type="email" name="email" placeholder="E-mail">
            </div>
                
            <div class="password">
                <label for="senha">Senha</label>
                <input type="password" name="senha" placeholder="Senha">
            </div>
                
            <div class="termsAndCondition">
                <label for="terms"><input type="checkbox"> Eu concordo com os termos e condições</label>
            </div>
            
            <input type="submit" value="Cadastrar">
        </form>
    </body>
</html>