<?php
require_once __DIR__ . '/src/config/Database.php';

try {
    $database = new Database();
    $db = $database->getConnection();
    
    // Verificar se a tabela existe
    $query = "SHOW TABLES LIKE 'atendimentos'";
    $stmt = $db->prepare($query);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        echo "A tabela 'atendimentos' existe.<br>";
        
        // Verificar a estrutura da tabela
        $query = "DESCRIBE atendimentos";
        $stmt = $db->prepare($query);
        $stmt->execute();
        
        echo "<h3>Estrutura da tabela:</h3>";
        echo "<pre>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            print_r($row);
        }
        echo "</pre>";
    } else {
        echo "A tabela 'atendimentos' não existe.<br>";
        
        // Criar a tabela
        $query = "CREATE TABLE atendimentos (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome_paciente VARCHAR(100) NOT NULL,
            nome_medico VARCHAR(100) NOT NULL,
            data_atendimento DATE NOT NULL,
            hora_atendimento TIME NOT NULL,
            tipo_atendimento ENUM('consulta', 'retorno', 'emergencia') NOT NULL,
            observacoes TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
        
        $stmt = $db->prepare($query);
        if ($stmt->execute()) {
            echo "Tabela 'atendimentos' criada com sucesso!<br>";
        } else {
            echo "Erro ao criar a tabela 'atendimentos'.<br>";
        }
    }
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
} 