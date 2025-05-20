-- Primeiro, vamos fazer backup dos dados existentes
CREATE TABLE consultas_backup AS SELECT * FROM consultas;

-- Agora vamos dropar a tabela antiga
DROP TABLE IF EXISTS consultas;

-- Criar a nova tabela com a estrutura correta
CREATE TABLE consultas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    paciente_id INT NOT NULL,
    medico_id INT NOT NULL,
    data_consulta DATE NOT NULL,
    hora_consulta TIME NOT NULL,
    tipo_consulta VARCHAR(50) NOT NULL,
    observacoes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (paciente_id) REFERENCES pacientes(id),
    FOREIGN KEY (medico_id) REFERENCES medicos(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Inserir os dados do backup (se necessário)
-- Note: Este passo pode precisar de ajustes dependendo da estrutura antiga dos dados
INSERT INTO consultas (paciente_id, medico_id, data_consulta, hora_consulta, tipo_consulta, observacoes)
SELECT 
    p.id as paciente_id,
    m.id as medico_id,
    c.data_consulta,
    c.hora_consulta,
    c.tipo_consulta,
    c.observacoes
FROM consultas_backup c
JOIN pacientes p ON p.nome = c.nome_paciente
JOIN medicos m ON m.nome = c.nome_medico;

-- Remover a tabela de backup após a migração
DROP TABLE IF EXISTS consultas_backup; 