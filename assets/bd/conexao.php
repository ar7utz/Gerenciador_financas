<?php
// Inclua a classe Banco
require_once 'banco.php';

// Estabeleça a conexão usando a classe Banco
$conexaoBanco = Banco::conectar();

// Você pode armazenar a conexão em $GLOBALS, mas considere usar uma abordagem mais modular
$GLOBALS['conexaoBanco'] = $conexaoBanco;

// Função para retornar um dado de uma consulta preparada
function retornaDado($sql, $params = [])
{
    $conexao = $GLOBALS['conexaoBanco'];
    $stmt = $conexao->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetch();
}

// Função para retornar todos os dados de uma consulta preparada
function retornaDados($sql, $params = [])
{
    $conexao = $GLOBALS['conexaoBanco'];
    $stmt = $conexao->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}
