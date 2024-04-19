<?php
    include_once '../../config.php';

    $nome              = $_POST['nome'];
    $email             = $_POST['email'];
    $senha             = $_POST['senha'];

    // Cria a sql para inserção no banco de dados
    $sql = "INSERT 
                INTO user 
                    (nome, email,) 
                VALUES 
                    (:nome, :email)";

    $res = $conexaoBanco->prepare($sql);

    $res->execute([
        ':nome'             => $nome,
        ':email'            => $email,
    ]);

    $id = $conexaoBanco->lastInsertId(); 
    
    function criarUsuario($email, $senha) {
        if(!empty($id)){
            header("Location: visualizar.php?id=$id");
        }else{
            header("Location: criar.php");
        }
    }
?>