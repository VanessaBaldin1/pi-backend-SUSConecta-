<?php

class Medico {
    private $conn;
    private $table_name = "medicos";

    public $id;
    public $nome;
    public $crm;
    public $especialidade;
    public $telefone;
    public $email;

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Verifica se o CRM já existe no banco de dados
     * @return bool
     */
    private function crmExists() {
        $query = "SELECT id FROM " . $this->table_name . " WHERE crm = :crm";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":crm", $this->crm);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function create() {
        try {
            // Verifica se o CRM já existe
            if ($this->crmExists()) {
                throw new Exception("Este CRM já está cadastrado no sistema.");
            }

            $query = "INSERT INTO " . $this->table_name . "
                    (nome, crm, especialidade, telefone, email)
                    VALUES
                    (:nome, :crm, :especialidade, :telefone, :email)";

            $stmt = $this->conn->prepare($query);

            $this->nome = htmlspecialchars(strip_tags($this->nome));
            $this->crm = htmlspecialchars(strip_tags($this->crm));
            $this->especialidade = htmlspecialchars(strip_tags($this->especialidade));
            $this->telefone = htmlspecialchars(strip_tags($this->telefone));
            $this->email = htmlspecialchars(strip_tags($this->email));

            $stmt->bindParam(":nome", $this->nome);
            $stmt->bindParam(":crm", $this->crm);
            $stmt->bindParam(":especialidade", $this->especialidade);
            $stmt->bindParam(":telefone", $this->telefone);
            $stmt->bindParam(":email", $this->email);

            if($stmt->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // Código de erro para violação de restrição única
                throw new Exception("Este CRM já está cadastrado no sistema.");
            }
            throw new Exception("Erro ao cadastrar médico: " . $e->getMessage());
        }
    }

    public function update() {
        try {
            // Verifica se o CRM já existe para outro médico
            if ($this->crmExists() && !$this->isCurrentMedico()) {
                throw new Exception("Este CRM já está cadastrado para outro médico.");
            }

            $query = "UPDATE " . $this->table_name . "
                    SET nome = :nome,
                        crm = :crm,
                        especialidade = :especialidade,
                        telefone = :telefone,
                        email = :email
                    WHERE id = :id";

            $stmt = $this->conn->prepare($query);

            $this->nome = htmlspecialchars(strip_tags($this->nome));
            $this->crm = htmlspecialchars(strip_tags($this->crm));
            $this->especialidade = htmlspecialchars(strip_tags($this->especialidade));
            $this->telefone = htmlspecialchars(strip_tags($this->telefone));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->id = htmlspecialchars(strip_tags($this->id));

            $stmt->bindParam(":nome", $this->nome);
            $stmt->bindParam(":crm", $this->crm);
            $stmt->bindParam(":especialidade", $this->especialidade);
            $stmt->bindParam(":telefone", $this->telefone);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":id", $this->id);

            if($stmt->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                throw new Exception("Este CRM já está cadastrado para outro médico.");
            }
            throw new Exception("Erro ao atualizar médico: " . $e->getMessage());
        }
    }

    /**
     * Verifica se o CRM pertence ao médico atual
     * @return bool
     */
    private function isCurrentMedico() {
        $query = "SELECT id FROM " . $this->table_name . " WHERE crm = :crm AND id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":crm", $this->crm);
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
            $this->crm = $row['crm'];
            $this->especialidade = $row['especialidade'];
            $this->telefone = $row['telefone'];
            $this->email = $row['email'];
            return true;
        }
        return false;
    }
} 