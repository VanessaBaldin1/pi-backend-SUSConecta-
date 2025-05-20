<?php
require_once __DIR__ . '/../Config/Database.php';
require_once __DIR__ . '/../Models/Medico.php';

class MedicoService {
    private $db;
    private $medico;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->medico = new Medico($this->db);
    }

    public function create($data) {
        try {
            $this->medico->nome = $data['nome'];
            $this->medico->crm = $data['crm'];
            $this->medico->especialidade = $data['especialidade'];
            $this->medico->telefone = $data['telefone'];
            $this->medico->email = $data['email'];

            if($this->medico->create()) {
                return [
                    'status' => 'sucesso',
                    'message' => 'Médico cadastrado com sucesso!'
                ];
            }
            return [
                'status' => 'erro',
                'message' => 'Erro ao cadastrar médico.'
            ];
        } catch (Exception $e) {
            return [
                'status' => 'erro',
                'message' => $e->getMessage()
            ];
        }
    }

    public function update($data) {
        try {
            $this->medico->id = $data['id'];
            $this->medico->nome = $data['nome'];
            $this->medico->crm = $data['crm'];
            $this->medico->especialidade = $data['especialidade'];
            $this->medico->telefone = $data['telefone'];
            $this->medico->email = $data['email'];

            if($this->medico->update()) {
                return [
                    'status' => 'sucesso',
                    'message' => 'Médico atualizado com sucesso!'
                ];
            }
            return [
                'status' => 'erro',
                'message' => 'Erro ao atualizar médico.'
            ];
        } catch (Exception $e) {
            return [
                'status' => 'erro',
                'message' => $e->getMessage()
            ];
        }
    }

    public function delete($id) {
        try {
            $this->medico->id = $id;
            if($this->medico->delete()) {
                return [
                    'status' => 'sucesso',
                    'message' => 'Médico excluído com sucesso!'
                ];
            }
            return [
                'status' => 'erro',
                'message' => 'Erro ao excluir médico.'
            ];
        } catch (Exception $e) {
            return [
                'status' => 'erro',
                'message' => $e->getMessage()
            ];
        }
    }

    public function getAll() {
        $stmt = $this->medico->read();
        $num = $stmt->rowCount();

        if($num > 0) {
            $medicos_arr = array();
            $medicos_arr["records"] = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                $medico_item = array(
                    "id" => $id,
                    "nome" => $nome,
                    "crm" => $crm,
                    "especialidade" => $especialidade,
                    "telefone" => $telefone,
                    "email" => $email
                );

                array_push($medicos_arr["records"], $medico_item);
            }

            return $medicos_arr;
        }

        return array("records" => array());
    }

    public function getOne($id) {
        $this->medico->id = $id;
        if($this->medico->readOne()) {
            return array(
                "id" => $this->medico->id,
                "nome" => $this->medico->nome,
                "crm" => $this->medico->crm,
                "especialidade" => $this->medico->especialidade,
                "telefone" => $this->medico->telefone,
                "email" => $this->medico->email
            );
        }
        return null;
    }

    // Método de compatibilidade para o index.php
    public function listarMedicos() {
        return $this->getAll();
    }
} 