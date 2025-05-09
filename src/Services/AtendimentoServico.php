<?php
namespace ConectaConsulta\Services;

use ConectaConsulta\Database\ConexaoBD;
use ConectaConsulta\models\Atendimento;
use PDO;

class AtendimentoServico {
    public $conexao;
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
        
        $this->conexao = ConexaoBD::getConexao();
    }
    

    public function getAtendimentosDoDia($medicoId) {
        $sql = "SELECT a.*, p.nome as nome_paciente 
                FROM atendimento a 
                JOIN Paciente p ON a.Paciente_id_paciente = p.id_paciente 
                WHERE DATE(a.data_hora) = CURDATE() 
                AND a.medico_id = ? 
                ORDER BY a.data_hora";
        $consulta = $this->conexao->prepare($sql);
        $consulta->execute([$medicoId]);
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUltimasConsultas($pacienteId) {
        $sql = "SELECT a.*, m.nome as nome_medico 
                FROM atendimento a 
                JOIN medico m ON a.medico_id = m.id_medico 
                WHERE a.Paciente_id_paciente = ? 
                ORDER BY a.data_hora DESC 
                LIMIT 10";
        $consulta = $this->conexao->prepare($sql);
        $consulta->execute([$pacienteId]);
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getObservacoesMedicas($pacienteId) {
        $sql = "SELECT a.data_hora, a.observacoes, m.nome as nome_medico 
                FROM atendimento a 
                JOIN medico m ON a.medico_id = m.id_medico 
                WHERE a.Paciente_id_paciente = ? 
                AND a.observacoes IS NOT NULL 
                ORDER BY a.data_hora DESC";
        $consulta = $this->conexao->prepare($sql);
        $consulta->execute([$pacienteId]);
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public function salvar(Atendimento $atendimento) {
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
            $consulta = $this->conexao->prepare($sql);
            return $consulta->execute([
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
                ) VALUES (:medicamento, :data_hora, :diagnostico, :prescricao, :observacoes, :status, :especialidades, :paciente_id, :hospital_clinica_id)";
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(":medicamento", $atendimento->getMedicamento(), PDO::PARAM_STR); // criar
            $consulta->bindValue(":data_hora", $atendimento->getDataHora(), PDO::PARAM_STR);
            $consulta->bindValue(":diagonistico", $atendimento->getDiagnostico(), PDO::PARAM_STR);
            $consulta->bindValue(":prescricao", $atendimento->getPrescricao(), PDO::PARAM_STR);
            $consulta->bindValue(":observacoes", $atendimento->getObservacoes(), PDO::PARAM_STR); // criar
            $result = $consulta->execute();
            if ($result) {
                $this->id = $this->conexao->lastInsertId();
            }
            return $result;
        }
    }
}
?>
