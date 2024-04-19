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

            <h1>Cadastro de Usuário</h1>

            <label for="NomeCompleto">Insira seu Nome Completo</label>
            <input type="text" value="Nome Completo">

            <label for="email">Insira seu E-mail</label>
            <input type="email" value="E-mail">
            
            <label for="Senha">Insira sua Senha</label>
            <input type="password" value="Senha">

            <input type="submit" value="Cadastrar">
        </form>
    </body>
</html>