<?php
namespace ConectaConsulta\Models;

use ConectaConsulta\Database\ConexaoBD;




class Paciente {
    private $pdo;

    public function __construct() {
         $this->pdo = ConexaoBD::getConexao();
    }

    public function inserirPaciente($nome, $data_nascimento, $cpf, $endereco, $telefone, $email) {
    try {
        $sql = "INSERT INTO paciente (nome, data_nascimento, cpf, endereco, telefone, email) 
                VALUES (:nome, :data_nascimento, :cpf, :endereco, :telefone, :email)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':nome' => $nome,
            ':data_nascimento' => $data_nascimento,
            ':cpf' => $cpf,
            ':endereco' => $endereco,
            ':telefone' => $telefone,
            ':email' => $email
        ]);

        echo "Paciente inserido com sucesso.";
    } catch (\PDOException $e) {
        echo "Erro PDO: " . $e->getMessage();
    }
}



    public function listarTodos() {
        $sql = "SELECT * FROM paciente ORDER BY id DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
