<?php
require_once __DIR__ . '/../models/Exame.php';
require_once __DIR__ . '/../config/Database.php';

class ExameService {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function criarExame($dados) {
        try {
            $query = "INSERT INTO exames (nome_paciente, nome_medico, tipo_exame, data_exame, hora_exame, resultado, status) 
                     VALUES (:nome_paciente, :nome_medico, :tipo_exame, :data_exame, :hora_exame, :resultado, :status)";
            
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(":nome_paciente", $dados['nome_paciente']);
            $stmt->bindParam(":nome_medico", $dados['nome_medico']);
            $stmt->bindParam(":tipo_exame", $dados['tipo_exame']);
            $stmt->bindParam(":data_exame", $dados['data_exame']);
            $stmt->bindParam(":hora_exame", $dados['hora_exame']);
            $stmt->bindParam(":resultado", $dados['resultado']);
            $stmt->bindParam(":status", $dados['status']);

            if($stmt->execute()) {
                return ["status" => "success", "message" => "Exame agendado com sucesso"];
            }
            return ["status" => "error", "message" => "Não foi possível agendar o exame"];
        } catch(PDOException $e) {
            return ["status" => "error", "message" => "Erro ao agendar exame: " . $e->getMessage()];
        }
    }

    public function listarExames() {
        try {
            $query = "SELECT * FROM exames ORDER BY data_exame DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            $exames = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return ["records" => $exames];
        } catch(PDOException $e) {
            echo "Erro ao listar exames: " . $e->getMessage();
            return ["records" => []];
        }
    }

    public function atualizarExame($dados) {
        try {
            $query = "UPDATE exames 
                     SET nome_paciente = :nome_paciente,
                         nome_medico = :nome_medico,
                         tipo_exame = :tipo_exame,
                         data_exame = :data_exame,
                         hora_exame = :hora_exame,
                         resultado = :resultado,
                         status = :status
                     WHERE id = :id";
            
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(":id", $dados['id']);
            $stmt->bindParam(":nome_paciente", $dados['nome_paciente']);
            $stmt->bindParam(":nome_medico", $dados['nome_medico']);
            $stmt->bindParam(":tipo_exame", $dados['tipo_exame']);
            $stmt->bindParam(":data_exame", $dados['data_exame']);
            $stmt->bindParam(":hora_exame", $dados['hora_exame']);
            $stmt->bindParam(":resultado", $dados['resultado']);
            $stmt->bindParam(":status", $dados['status']);

            if($stmt->execute()) {
                return ["status" => "success", "message" => "Exame atualizado com sucesso"];
            }
            return ["status" => "error", "message" => "Não foi possível atualizar o exame"];
        } catch(PDOException $e) {
            return ["status" => "error", "message" => "Erro ao atualizar exame: " . $e->getMessage()];
        }
    }

    public function excluirExame($id) {
        try {
            $query = "DELETE FROM exames WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $id);
            
            if($stmt->execute()) {
                return ["status" => "success", "message" => "Exame excluído com sucesso"];
            }
            return ["status" => "error", "message" => "Não foi possível excluir o exame"];
        } catch(PDOException $e) {
            return ["status" => "error", "message" => "Erro ao excluir exame: " . $e->getMessage()];
        }
    }

    public function buscarExame($id) {
        try {
            $query = "SELECT * FROM exames WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo "Erro ao buscar exame: " . $e->getMessage();
            return null;
        }
    }
} 