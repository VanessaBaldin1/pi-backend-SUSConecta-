<?php
require_once '../src/Database/Conexao.php';

class Medico {
    public $db;
    public $id;
    public $nome;
    public $crm;
    public $especialidade;
    public $telefone;
    public $email;
    public $pacienteId;

    public function __construct() {
        $this->db = new Database();
    }

    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getCrm() {
        return $this->crm;
    }

    public function getEspecialidade() {
        return $this->especialidade;
    }

    public function getTelefone() {
        return $this->telefone;
    }

    public function getEmail() {
        return $this->email;
    }

    public function carregarPorId($id) {
        $sql = "SELECT * FROM medico WHERE id_medico = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $medico = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($medico) {
            $this->id = $medico['id_medico'];
            $this->nome = $medico['nome'];
            $this->crm = $medico['crm'];
            $this->especialidade = $medico['especialidade'];
            $this->telefone = $medico['telefone'];
            $this->email = $medico['email'];
            $this->pacienteId = $medico['Paciente_id_paciente'];
            return true;
        }
        return false;
    }

    public function salvar() {
        if ($this->id) {
            $sql = "UPDATE medico SET 
                    nome = ?, 
                    crm = ?, 
                    especialidade = ?, 
                    telefone = ?, 
                    email = ?, 
                    Paciente_id_paciente = ? 
                    WHERE id_medico = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                $this->nome,
                $this->crm,
                $this->especialidade,
                $this->telefone,
                $this->email,
                $this->pacienteId,
                $this->id
            ]);
        } else {
            $sql = "INSERT INTO medico (nome, crm, especialidade, telefone, email, Paciente_id_paciente) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([
                $this->nome,
                $this->crm,
                $this->especialidade,
                $this->telefone,
                $this->email,
                $this->pacienteId
            ]);
            if ($result) {
                $this->id = $this->db->lastInsertId();
            }
            return $result;
        }
    }
}
?>
