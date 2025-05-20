<?php

class Consulta {
    private $conn;
    private $table_name = "consultas";

    public $id;
    public $paciente_id;
    public $medico_id;
    public $data_consulta;
    public $hora_consulta;
    public $tipo_consulta;
    public $observacoes;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
                (paciente_id, medico_id, data_consulta, hora_consulta, tipo_consulta, observacoes)
                VALUES
                (:paciente_id, :medico_id, :data_consulta, :hora_consulta, :tipo_consulta, :observacoes)";

        $stmt = $this->conn->prepare($query);

        $this->paciente_id = htmlspecialchars(strip_tags($this->paciente_id));
        $this->medico_id = htmlspecialchars(strip_tags($this->medico_id));
        $this->data_consulta = htmlspecialchars(strip_tags($this->data_consulta));
        $this->hora_consulta = htmlspecialchars(strip_tags($this->hora_consulta));
        $this->tipo_consulta = htmlspecialchars(strip_tags($this->tipo_consulta));
        $this->observacoes = htmlspecialchars(strip_tags($this->observacoes));

        $stmt->bindParam(":paciente_id", $this->paciente_id);
        $stmt->bindParam(":medico_id", $this->medico_id);
        $stmt->bindParam(":data_consulta", $this->data_consulta);
        $stmt->bindParam(":hora_consulta", $this->hora_consulta);
        $stmt->bindParam(":tipo_consulta", $this->tipo_consulta);
        $stmt->bindParam(":observacoes", $this->observacoes);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . "
                SET
                    paciente_id = :paciente_id,
                    medico_id = :medico_id,
                    data_consulta = :data_consulta,
                    hora_consulta = :hora_consulta,
                    tipo_consulta = :tipo_consulta,
                    observacoes = :observacoes
                WHERE
                    id = :id";

        $stmt = $this->conn->prepare($query);

        $this->paciente_id = htmlspecialchars(strip_tags($this->paciente_id));
        $this->medico_id = htmlspecialchars(strip_tags($this->medico_id));
        $this->data_consulta = htmlspecialchars(strip_tags($this->data_consulta));
        $this->hora_consulta = htmlspecialchars(strip_tags($this->hora_consulta));
        $this->tipo_consulta = htmlspecialchars(strip_tags($this->tipo_consulta));
        $this->observacoes = htmlspecialchars(strip_tags($this->observacoes));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":paciente_id", $this->paciente_id);
        $stmt->bindParam(":medico_id", $this->medico_id);
        $stmt->bindParam(":data_consulta", $this->data_consulta);
        $stmt->bindParam(":hora_consulta", $this->hora_consulta);
        $stmt->bindParam(":tipo_consulta", $this->tipo_consulta);
        $stmt->bindParam(":observacoes", $this->observacoes);
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function read() {
        $query = "SELECT c.*, p.nome as nome_paciente, m.nome as nome_medico 
                 FROM " . $this->table_name . " c
                 INNER JOIN pacientes p ON c.paciente_id = p.id
                 INNER JOIN medicos m ON c.medico_id = m.id
                 ORDER BY c.data_consulta DESC, c.hora_consulta DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT c.*, p.nome as nome_paciente, m.nome as nome_medico 
                 FROM " . $this->table_name . " c
                 INNER JOIN pacientes p ON c.paciente_id = p.id
                 INNER JOIN medicos m ON c.medico_id = m.id
                 WHERE c.id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row) {
            $this->paciente_id = $row['paciente_id'];
            $this->medico_id = $row['medico_id'];
            $this->data_consulta = $row['data_consulta'];
            $this->hora_consulta = $row['hora_consulta'];
            $this->tipo_consulta = $row['tipo_consulta'];
            $this->observacoes = $row['observacoes'];
            return true;
        }
        return false;
    }
} 