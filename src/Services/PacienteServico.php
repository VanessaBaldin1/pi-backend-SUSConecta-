<?php

namespace ConectaConsulta\Services;

use ConectaConsulta\Database\ConexaoBD;
use Exception;
use PDO;


class PacienteServico {
    public $conexao;
    public $id;
    public $nome;
    public $dataNascimento;
    public $cpf;
    public $endereco;
    public $telefone;
    public $email;

    public function __construct() {
        try{
          $this->conexao =  ConexaoBD::getConexao();  
        } catch ( Exception $ConectaConsulta){
            die("Erro de conexão: " . $ConectaConsulta->getMessage());
        }
        
    }

    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getDataNascimento() {
        return $this->dataNascimento;
    }

    public function getCpf() {
        return $this->cpf;
    }

    public function getEndereco() {
        return $this->endereco;
    }

    public function getTelefone() {
        return $this->telefone;
    }

    public function getEmail() {
        return $this->email;
    }

    public function carregarPorId($id) {
        $sql = "SELECT * FROM Paciente WHERE id_paciente = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([$id]);
        $paciente = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($paciente) {
            $this->id = $paciente['id_paciente'];
            $this->nome = $paciente['nome'];
            $this->dataNascimento = $paciente['data_nascimento'];
            $this->cpf = $paciente['cpf'];
            $this->endereco = $paciente['endereco'];
            $this->telefone = $paciente['telefone'];
            $this->email = $paciente['email'];
            return true;
        }
        return false;
    }

    public function salvar() {
        if ($this->id) {
            $sql = "UPDATE Paciente SET 
                    nome = ?, 
                    data_nascimento = ?, 
                    cpf = ?, 
                    endereco = ?, 
                    telefone = ?, 
                    email = ? 
                    WHERE id_paciente = ?";
            $stmt = $this->conexao->prepare($sql);
            return $stmt->execute([
                $this->nome,
                $this->dataNascimento,
                $this->cpf,
                $this->endereco,
                $this->telefone,
                $this->email,
                $this->id
            ]);
        } else {
            $sql = "INSERT INTO Paciente (nome, data_nascimento, cpf, endereco, telefone, email) 
                    VALUES (:nome,:data_nascimento,:cpf,:endereco,:telefone ,:email )";
            $stmt = $this->conexao->prepare($sql);
            $result = $stmt->execute([
                $this->nome,
                $this->dataNascimento,
                $this->cpf,
                $this->endereco,
                $this->telefone,
                $this->email
            ]);
            if ($result) {
                $this->id = $this->conexao->lastInsertId();
            }
            return $result;
        }
    }
}
?>
