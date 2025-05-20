-- Inserir dados de exemplo para pacientes
INSERT INTO pacientes (nome, cpf, data_nascimento, telefone, email, endereco) VALUES
('Maria Silva', '123.456.789-00', '1985-05-15', '(11) 98765-4321', 'maria.silva@email.com', 'Rua das Flores, 123'),
('João Santos', '987.654.321-00', '1978-10-20', '(11) 91234-5678', 'joao.santos@email.com', 'Av. Principal, 456'),
('Ana Oliveira', '456.789.123-00', '1990-03-25', '(11) 99876-5432', 'ana.oliveira@email.com', 'Rua dos Pássaros, 789'),
('Pedro Costa', '789.123.456-00', '1982-07-12', '(11) 97777-8888', 'pedro.costa@email.com', 'Av. Central, 321'),
('Carla Mendes', '321.654.987-00', '1995-12-30', '(11) 96666-5555', 'carla.mendes@email.com', 'Rua das Árvores, 654');

-- Inserir dados de exemplo para médicos
INSERT INTO medicos (nome, crm, especialidade, telefone, email) VALUES
('Dr. Carlos Ferreira', '12345-SP', 'Clínico Geral', '(11) 98888-7777', 'carlos.ferreira@email.com'),
('Dra. Juliana Lima', '54321-SP', 'Cardiologista', '(11) 95555-4444', 'juliana.lima@email.com'),
('Dr. Roberto Alves', '98765-SP', 'Ortopedista', '(11) 94444-3333', 'roberto.alves@email.com'),
('Dra. Patricia Santos', '45678-SP', 'Pediatra', '(11) 93333-2222', 'patricia.santos@email.com'),
('Dr. Marcelo Costa', '87654-SP', 'Neurologista', '(11) 92222-1111', 'marcelo.costa@email.com');

-- Inserir dados de exemplo para consultas
INSERT INTO consultas (paciente_id, medico_id, data_consulta, hora_consulta, tipo_consulta, observacoes) VALUES
(1, 1, '2024-03-20', '09:00', 'consulta', 'Primeira consulta'),
(2, 2, '2024-03-21', '10:30', 'retorno', 'Acompanhamento'),
(3, 1, '2024-03-22', '14:00', 'emergencia', 'Urgente');

-- Inserir dados de exemplo para exames
INSERT INTO exames (paciente_id, medico_id, tipo_exame, data_exame, hora_exame, resultado, status) VALUES
(1, 1, 'Hemograma Completo', '2024-03-25', '08:00:00', 'Resultado normal', 'realizado'),
(2, 2, 'Eletrocardiograma', '2024-03-26', '09:30:00', 'Arritmia leve detectada', 'realizado'),
(3, 3, 'Raio-X Joelho', '2024-03-27', '10:00:00', 'Sem alterações significativas', 'realizado'),
(4, 4, 'Teste COVID-19', '2024-03-28', '11:30:00', 'Negativo', 'realizado'),
(5, 5, 'Tomografia Cerebral', '2024-03-29', '14:00:00', 'Sem alterações', 'agendado'); 