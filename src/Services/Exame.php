<?php
require_once '../src/Database/Conexao.php';



class Exame {
    public $db;
    public $id;
    public $idConsulta;
    public $tipo;
    public $resultado;
    public $laboratorio;
    public $data;
    public $atendimentoId;
    public $pacienteId;

    public function __construct() {
        $this->db = new Database();
    }

    public function getExamesPaciente($pacienteId) {
        $sql = "SELECT e.*, a.data_hora 
                FROM exame e 
                JOIN atendimento a ON e.atendimento_id_atendimento = a.id_atendimento 
                WHERE e.atendimento_Paciente_id_paciente = ? 
                ORDER BY e.data DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$pacienteId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function salvar() {
        if ($this->id) {
            $sql = "UPDATE exame SET 
                    id_consulta = ?, 
                    tipo = ?, 
                    resultado = ?, 
                    laboratorio = ?, 
                    data = ?, 
                    atendimento_id_atendimento = ?, 
                    atendimento_Paciente_id_paciente = ? 
                    WHERE id_exame = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                $this->idConsulta,
                $this->tipo,
                $this->resultado,
                $this->laboratorio,
                $this->data,
                $this->atendimentoId,
                $this->pacienteId,
                $this->id
            ]);
        } else {
            $sql = "INSERT INTO exame (
                    id_consulta, tipo, resultado, laboratorio, 
                    data, atendimento_id_atendimento, atendimento_Paciente_id_paciente
                ) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([
                $this->idConsulta,
                $this->tipo,
                $this->resultado,
                $this->laboratorio,
                $this->data,
                $this->atendimentoId,
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