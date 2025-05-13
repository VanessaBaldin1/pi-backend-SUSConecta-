<?php
namespace ConectaConsulta\Models;

use ConectaConsulta\Database\ConexaoBD;


class Exame {
    public $id_consulta;
    public $tipo;
    public $resultado;
    public $laboratorio;
    public $data;
    public $atendimento_id_atendimento;
    public $atendimento_Paciente_id_paciente;

    public function __construct($id_consulta, $tipo, $resultado, $laboratorio, $data, $atendimento_id_atendimento, $atendimento_Paciente_id_paciente) {
        $this->id_consulta = $id_consulta;
        $this->tipo = $tipo;
        $this->resultado = $resultado;
        $this->laboratorio = $laboratorio;
        $this->data = $data;
        $this->atendimento_id_atendimento = $atendimento_id_atendimento;
        $this->atendimento_Paciente_id_paciente = $atendimento_Paciente_id_paciente;
    }

    public function salvar() {
        $pdo = ConexaoBD::getConexao();
        $sql = 'INSERT INTO exame (id_consulta, tipo, resultado, laboratorio, data, atendimento_id_atendimento, atendimento_Paciente_id_paciente) VALUES (?, ?, ?, ?, ?, ?, ?)';
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            $this->id_consulta,
            $this->tipo,
            $this->resultado,
            $this->laboratorio,
            $this->data,
            $this->atendimento_id_atendimento,
            $this->atendimento_Paciente_id_paciente
        ]);
    }
} 