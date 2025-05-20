<?php
require_once __DIR__ . '/Database.php';

try {
    $database = new Database();
    $conn = $database->getConnection();
    
    // Criar a tabela atendimentos
    $sql = "CREATE TABLE IF NOT EXISTS atendimentos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        paciente_id INT NOT NULL,
        medico_id INT NOT NULL,
        data_atendimento DATE NOT NULL,
        hora_atendimento TIME NOT NULL,
        tipo_atendimento ENUM('consulta', 'retorno', 'emergencia') NOT NULL,
        observacoes TEXT,
        status ENUM('agendado', 'em_andamento', 'concluido', 'cancelado') NOT NULL DEFAULT 'agendado',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (paciente_id) REFERENCES pacientes(id),
        FOREIGN KEY (medico_id) REFERENCES medicos(id)
    )";
    
    $conn->exec($sql);
    echo "Tabela 'atendimentos' criada com sucesso!";
    
} catch(PDOException $e) {
    echo "Erro ao criar tabela: " . $e->getMessage();
} 