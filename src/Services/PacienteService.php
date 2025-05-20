<?php
require_once __DIR__ . '/../Config/Database.php';
require_once __DIR__ . '/../Models/Paciente.php';

class PacienteService {
    private $db;
    private $paciente;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->paciente = new Paciente($this->db);
    }

    public function create($data) {
        try {
            $this->paciente->nome = $data['nome'];
            $this->paciente->cpf = $data['cpf'];
            $this->paciente->data_nascimento = $data['data_nascimento'];
            $this->paciente->telefone = $data['telefone'];
            $this->paciente->email = $data['email'];
            $this->paciente->endereco = $data['endereco'];

            if($this->paciente->create()) {
                return [
                    'status' => 'sucesso',
                    'message' => 'Paciente cadastrado com sucesso!'
                ];
            }
            return [
                'status' => 'erro',
                'message' => 'Erro ao cadastrar paciente.'
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
            $this->paciente->id = $data['id'];
            $this->paciente->nome = $data['nome'];
            $this->paciente->cpf = $data['cpf'];
            $this->paciente->data_nascimento = $data['data_nascimento'];
            $this->paciente->telefone = $data['telefone'];
            $this->paciente->email = $data['email'];
            $this->paciente->endereco = $data['endereco'];

            if($this->paciente->update()) {
                return [
                    'status' => 'sucesso',
                    'message' => 'Paciente atualizado com sucesso!'
                ];
            }
            return [
                'status' => 'erro',
                'message' => 'Erro ao atualizar paciente.'
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
            $this->paciente->id = $id;
            if($this->paciente->delete()) {
                return [
                    'status' => 'sucesso',
                    'message' => 'Paciente excluído com sucesso!'
                ];
            }
            return [
                'status' => 'erro',
                'message' => 'Erro ao excluir paciente.'
            ];
        } catch (Exception $e) {
            return [
                'status' => 'erro',
                'message' => $e->getMessage()
            ];
        }
    }

    public function getAll() {
        $stmt = $this->paciente->read();
        $num = $stmt->rowCount();

        if($num > 0) {
            $pacientes_arr = array();
            $pacientes_arr["records"] = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                $paciente_item = array(
                    "id" => $id,
                    "nome" => $nome,
                    "cpf" => $cpf,
                    "data_nascimento" => $data_nascimento,
                    "telefone" => $telefone,
                    "email" => $email,
                    "endereco" => $endereco
                );

                array_push($pacientes_arr["records"], $paciente_item);
            }

            return $pacientes_arr;
        }

        return array("records" => array());
    }

    public function getOne($id) {
        $this->paciente->id = $id;
        if($this->paciente->readOne()) {
            return array(
                "id" => $this->paciente->id,
                "nome" => $this->paciente->nome,
                "cpf" => $this->paciente->cpf,
                "data_nascimento" => $this->paciente->data_nascimento,
                "telefone" => $this->paciente->telefone,
                "email" => $this->paciente->email,
                "endereco" => $this->paciente->endereco
            );
        }
        return null;
    }

    // Método de compatibilidade para o index.php
    public function listarPacientes() {
        return $this->getAll();
    }
} 