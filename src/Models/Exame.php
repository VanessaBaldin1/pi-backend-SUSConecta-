<?php

class Exame {
    private $conn;
    private $table_name = "exames";

    public $id;
    public $paciente_id;
    public $medico_id;
    public $tipo_exame;
    public $data_exame;
    public $hora_exame;
    public $resultado;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function criar($dados) {
        $query = "INSERT INTO " . $this->table_name . "
                (paciente_id, medico_id, tipo_exame, data_exame, hora_exame, resultado, status)
                VALUES
                (:paciente_id, :medico_id, :tipo_exame, :data_exame, :hora_exame, :resultado, :status)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":paciente_id", $dados['paciente_id']);
        $stmt->bindParam(":medico_id", $dados['medico_id']);
        $stmt->bindParam(":tipo_exame", $dados['tipo_exame']);
        $stmt->bindParam(":data_exame", $dados['data_exame']);
        $stmt->bindParam(":hora_exame", $dados['hora_exame']);
        $stmt->bindParam(":resultado", $dados['resultado']);
        $stmt->bindParam(":status", $dados['status']);

        if($stmt->execute()) {
            return true;
        }
        throw new Exception("Erro ao criar exame");
    }

    public function atualizar($dados) {
        $query = "UPDATE " . $this->table_name . "
                SET
                    paciente_id = :paciente_id,
                    medico_id = :medico_id,
                    tipo_exame = :tipo_exame,
                    data_exame = :data_exame,
                    hora_exame = :hora_exame,
                    resultado = :resultado,
                    status = :status
                WHERE
                    id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $dados['id']);
        $stmt->bindParam(":paciente_id", $dados['paciente_id']);
        $stmt->bindParam(":medico_id", $dados['medico_id']);
        $stmt->bindParam(":tipo_exame", $dados['tipo_exame']);
        $stmt->bindParam(":data_exame", $dados['data_exame']);
        $stmt->bindParam(":hora_exame", $dados['hora_exame']);
        $stmt->bindParam(":resultado", $dados['resultado']);
        $stmt->bindParam(":status", $dados['status']);

        if($stmt->execute()) {
            return true;
        }
        throw new Exception("Erro ao atualizar exame");
    }

    public function excluir($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);

        if($stmt->execute()) {
            return true;
        }
        throw new Exception("Erro ao excluir exame");
    }

    public function listar() {
        $query = "SELECT e.*, p.nome as nome_paciente, m.nome as nome_medico 
                FROM " . $this->table_name . " e
                LEFT JOIN pacientes p ON e.paciente_id = p.id
                LEFT JOIN medicos m ON e.medico_id = m.id
                ORDER BY e.data_exame DESC, e.hora_exame DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscar($id) {
        $query = "SELECT e.*, p.nome as nome_paciente, m.nome as nome_medico 
                FROM " . $this->table_name . " e
                LEFT JOIN pacientes p ON e.paciente_id = p.id
                LEFT JOIN medicos m ON e.medico_id = m.id
                WHERE e.id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row) {
            return $row;
        }
        throw new Exception("Exame não encontrado");
    }
} 