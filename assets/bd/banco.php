<?php

class Banco
{
    private static $dbNome = 'bd_gffa';
    private static $dbHost = '127.0.0.1';
    private static $dbUsuario = 'root';
    private static $dbSenha = '';

    private static $cont = null;

    // Método privado para impedir instâncias diretas
    private function __construct() {}

    // Método para conectar ao banco de dados
    public static function conectar()
    {
        if (self::$cont === null) {
            try {
                self::$cont = new PDO(
                    "mysql:host=" . self::$dbHost . ";dbname=" . self::$dbNome . ";charset=utf8mb4",
                    self::$dbUsuario,
                    self::$dbSenha
                );
                self::$cont->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $exception) {
                throw new RuntimeException("Erro ao conectar ao banco de dados: " . $exception->getMessage());
            }
        }
        return self::$cont;
    }

    // Método para desconectar do banco de dados
    public static function desconectar()
    {
        self::$cont = null;
    }
}
