<?php
require_once '../src/Database/Conexao.php';
require_once '../src/Services/Conexao.php';

class Atendimento {
    public $db;
    public $id;
    public $medicamento;
    public $dataHora;
    public $diagnostico;
    public $prescricao;
    public $observacoes;
    public $status;
    public $especialidades;
    public $pacienteId;
    public $hospitalId;

    
    public function __construct() {
        $this->db = new Database();
    }
    

    public function getAtendimentosDoDia($medicoId) {
        $sql = "SELECT a.*, p.nome as nome_paciente 
                FROM atendimento a 
                JOIN Paciente p ON a.Paciente_id_paciente = p.id_paciente 
                WHERE DATE(a.data_hora) = CURDATE() 
                AND a.medico_id = ? 
                ORDER BY a.data_hora";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$medicoId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUltimasConsultas($pacienteId) {
        $sql = "SELECT a.*, m.nome as nome_medico 
                FROM atendimento a 
                JOIN medico m ON a.medico_id = m.id_medico 
                WHERE a.Paciente_id_paciente = ? 
                ORDER BY a.data_hora DESC 
                LIMIT 10";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$pacienteId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getObservacoesMedicas($pacienteId) {
        $sql = "SELECT a.data_hora, a.observacoes, m.nome as nome_medico 
                FROM atendimento a 
                JOIN medico m ON a.medico_id = m.id_medico 
                WHERE a.Paciente_id_paciente = ? 
                AND a.observacoes IS NOT NULL 
                ORDER BY a.data_hora DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$pacienteId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function salvar() {
        if ($this->id) {
            $sql = "UPDATE atendimento SET 
                    medicamento = ?, 
                    data_hora = ?, 
                    diagnostico = ?, 
                    prescricao = ?, 
                    observacoes = ?, 
                    status = ?, 
                    especialidades = ?, 
                    Paciente_id_paciente = ?, 
                    hospital_clinica_id_hospital = ? 
                    WHERE id_atendimento = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                $this->medicamento,
                $this->dataHora,
                $this->diagnostico,
                $this->prescricao,
                $this->observacoes,
                $this->status,
                $this->especialidades,
                $this->pacienteId,
                $this->hospitalId,
                $this->id
            ]);
        } else {
            $sql = "INSERT INTO atendimento (
                    medicamento, data_hora, diagnostico, prescricao, 
                    observacoes, status, especialidades, 
                    Paciente_id_paciente, hospital_clinica_id_hospital
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([
                $this->medicamento,
                $this->dataHora,
                $this->diagnostico,
                $this->prescricao,
                $this->observacoes,
                $this->status,
                $this->especialidades,
                $this->pacienteId,
                $this->hospitalId
            ]);
            if ($result) {
                $this->id = $this->db->lastInsertId();
            }
            return $result;
        }
    }
}
?>
