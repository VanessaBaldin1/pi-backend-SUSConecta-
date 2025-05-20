<?php

class Paciente {
    private $conn;
    private $table_name = "pacientes";

    public $id;
    public $nome;
    public $cpf;
    public $data_nascimento;
    public $telefone;
    public $email;
    public $endereco;

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Verifica se o CPF já existe no banco de dados
     * @return bool
     */
    private function cpfExists() {
        $query = "SELECT id FROM " . $this->table_name . " WHERE cpf = :cpf";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":cpf", $this->cpf);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function create() {
        try {
            // Verifica se o CPF já existe
            if ($this->cpfExists()) {
                throw new Exception("Este CPF já está cadastrado no sistema.");
            }

            $query = "INSERT INTO " . $this->table_name . "
                    (nome, cpf, data_nascimento, telefone, email, endereco)
                    VALUES
                    (:nome, :cpf, :data_nascimento, :telefone, :email, :endereco)";

            $stmt = $this->conn->prepare($query);

            $this->nome = htmlspecialchars(strip_tags($this->nome));
            $this->cpf = htmlspecialchars(strip_tags($this->cpf));
            $this->data_nascimento = htmlspecialchars(strip_tags($this->data_nascimento));
            $this->telefone = htmlspecialchars(strip_tags($this->telefone));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->endereco = htmlspecialchars(strip_tags($this->endereco));

            $stmt->bindParam(":nome", $this->nome);
            $stmt->bindParam(":cpf", $this->cpf);
            $stmt->bindParam(":data_nascimento", $this->data_nascimento);
            $stmt->bindParam(":telefone", $this->telefone);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":endereco", $this->endereco);

            if($stmt->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // Código de erro para violação de restrição única
                throw new Exception("Este CPF já está cadastrado no sistema.");
            }
            throw new Exception("Erro ao cadastrar paciente: " . $e->getMessage());
        }
    }

    public function update() {
        try {
            // Verifica se o CPF já existe para outro paciente
            if ($this->cpfExists() && !$this->isCurrentPaciente()) {
                throw new Exception("Este CPF já está cadastrado para outro paciente.");
            }

            $query = "UPDATE " . $this->table_name . "
                    SET nome = :nome,
                        cpf = :cpf,
                        data_nascimento = :data_nascimento,
                        telefone = :telefone,
                        email = :email,
                        endereco = :endereco
                    WHERE id = :id";

            $stmt = $this->conn->prepare($query);

            $this->nome = htmlspecialchars(strip_tags($this->nome));
            $this->cpf = htmlspecialchars(strip_tags($this->cpf));
            $this->data_nascimento = htmlspecialchars(strip_tags($this->data_nascimento));
            $this->telefone = htmlspecialchars(strip_tags($this->telefone));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->endereco = htmlspecialchars(strip_tags($this->endereco));
            $this->id = htmlspecialchars(strip_tags($this->id));

            $stmt->bindParam(":nome", $this->nome);
            $stmt->bindParam(":cpf", $this->cpf);
            $stmt->bindParam(":data_nascimento", $this->data_nascimento);
            $stmt->bindParam(":telefone", $this->telefone);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":endereco", $this->endereco);
            $stmt->bindParam(":id", $this->id);

            if($stmt->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                throw new Exception("Este CPF já está cadastrado para outro paciente.");
            }
            throw new Exception("Erro ao atualizar paciente: " . $e->getMessage());
        }
    }

    /**
     * Verifica se o CPF pertence ao paciente atual
     * @return bool
     */
    private function isCurrentPaciente() {
        $query = "SELECT id FROM " . $this->table_name . " WHERE cpf = :cpf AND id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":cpf", $this->cpf);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY nome ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row) {
            $this->nome = $row['nome'];
            $this->cpf = $row['cpf'];
            $this->data_nascimento = $row['data_nascimento'];
            $this->telefone = $row['telefone'];
            $this->email = $row['email'];
            $this->endereco = $row['endereco'];
            return true;
        }
        return false;
    }
} 