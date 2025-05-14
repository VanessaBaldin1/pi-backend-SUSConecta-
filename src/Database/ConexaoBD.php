<?php

namespace ConectaConsulta\Database;

use Exception;
use PDO;
use Throwable;

abstract class ConexaoBD
{
    private static ?PDO $conexao = null;
    private static string $servidor = "localhost";
    private static string $usuario = "root";
    private static string $senha = "";
    private static string $banco = "susconecta";

    public static function getConexao(): PDO
    {
        if (!isset(self::$conexao)) {
            try {
                self::$conexao = new PDO(
                    "mysql:host=" . self::$servidor . ";dbname=" . self::$banco . ";charset=utf8",
                    self::$usuario,
                    self::$senha
                );

                self::$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (Throwable $erro) {
                // Exibir erro real no ambiente de desenvolvimento
                die("Erro ao conectar com o banco de dados: " . $erro->getMessage());

                // Em produção, comente a linha acima e ative esta:
                // throw new Exception("Erro ao conectar com o banco de dados!");
            }
        }

        return self::$conexao;
    }
}
