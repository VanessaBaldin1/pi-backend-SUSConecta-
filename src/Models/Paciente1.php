<?php
namespace ConectaConsulta\Models;

use ConectaConsulta\Database\ConexaoBD;


class Paciente {
    public $nome;
    public $data_nascimento;
    public $cpf;
    public $endereco;
    public $telefone;
    public $email;

    public function __construct($nome, $data_nascimento, $cpf, $endereco, $telefone, $email) {
        $this->nome = $nome;
        $this->data_nascimento = $data_nascimento;
        $this->cpf = $cpf;
        $this->endereco = $endereco;
        $this->telefone = $telefone;
        $this->email = $email;
    }

    public function salvar() {
        $pdo = ConexaoBD::getConexao();
        $sql = 'INSERT INTO Paciente (nome, data_nascimento, cpf, endereco, telefone, email) VALUES (?, ?, ?, ?, ?, ?)';
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            $this->nome,
            $this->data_nascimento,
            $this->cpf,
            $this->endereco,
            $this->telefone,
            $this->email
        ]);
    }
} 