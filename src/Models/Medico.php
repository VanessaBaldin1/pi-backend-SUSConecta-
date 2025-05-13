<?php
namespace ConectaConsulta\Models;

use ConectaConsulta\Database\ConexaoBD;

class Medico {
    public $nome;
    public $crm;
    public $especialidade;
    public $telefone;
    public $email;

    public function __construct($nome, $crm, $especialidade, $telefone, $email) {
        $this->nome = $nome;
        $this->crm = $crm;
        $this->especialidade = $especialidade;
        $this->telefone = $telefone;
        $this->email = $email;
    }

    public function salvar() {
        $pdo = ConexaoBD::getConexao();
        $sql = 'INSERT INTO medico (nome, crm, especialidade, telefone, email) VALUES (?, ?, ?, ?, ?)';
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            $this->nome,
            $this->crm,
            $this->especialidade,
            $this->telefone,
            $this->email
        ]);
    }
} 