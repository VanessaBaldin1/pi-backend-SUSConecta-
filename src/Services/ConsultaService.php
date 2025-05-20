<?php

require_once __DIR__ . '/../Config/Database.php';
require_once __DIR__ . '/../Models/Consulta.php';

class ConsultaService {
    private $db;
    private $consulta;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->consulta = new Consulta($this->db);
    }

    public function create($data) {
        $this->consulta->paciente_id = $data['paciente_id'];
        $this->consulta->medico_id = $data['medico_id'];
        $this->consulta->data_consulta = $data['data_consulta'];
        $this->consulta->hora_consulta = $data['hora_consulta'];
        $this->consulta->tipo_consulta = $data['tipo_consulta'];
        $this->consulta->observacoes = $data['observacoes'];

        if($this->consulta->create()) {
            return true;
        }
        return false;
    }

    public function update($data) {
        $this->consulta->id = $data['id'];
        $this->consulta->paciente_id = $data['paciente_id'];
        $this->consulta->medico_id = $data['medico_id'];
        $this->consulta->data_consulta = $data['data_consulta'];
        $this->consulta->hora_consulta = $data['hora_consulta'];
        $this->consulta->tipo_consulta = $data['tipo_consulta'];
        $this->consulta->observacoes = $data['observacoes'];

        if($this->consulta->update()) {
            return true;
        }
        return false;
    }

    public function delete($id) {
        $this->consulta->id = $id;
        if($this->consulta->delete()) {
            return true;
        }
        return false;
    }

    public function getAll() {
        $stmt = $this->consulta->read();
        $num = $stmt->rowCount();

        if($num > 0) {
            $consultas_arr = array();
            $consultas_arr["records"] = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                $consulta_item = array(
                    "id" => $id,
                    "paciente_id" => $paciente_id,
                    "medico_id" => $medico_id,
                    "nome_paciente" => $nome_paciente,
                    "nome_medico" => $nome_medico,
                    "data_consulta" => $data_consulta,
                    "hora_consulta" => $hora_consulta,
                    "tipo_consulta" => $tipo_consulta,
                    "observacoes" => $observacoes
                );

                array_push($consultas_arr["records"], $consulta_item);
            }

            return $consultas_arr;
        }

        return array("records" => array());
    }

    public function getOne($id) {
        $this->consulta->id = $id;
        if($this->consulta->readOne()) {
            return array(
                "id" => $this->consulta->id,
                "paciente_id" => $this->consulta->paciente_id,
                "medico_id" => $this->consulta->medico_id,
                "data_consulta" => $this->consulta->data_consulta,
                "hora_consulta" => $this->consulta->hora_consulta,
                "tipo_consulta" => $this->consulta->tipo_consulta,
                "observacoes" => $this->consulta->observacoes
            );
        }
        return null;
    }

    // Método de compatibilidade para o index.php
    public function listarConsultas() {
        return $this->getAll();
    }
} 