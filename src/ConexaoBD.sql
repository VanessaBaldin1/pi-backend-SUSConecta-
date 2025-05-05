-- Criação do banco de dados SUSConecta
CREATE DATABASE IF NOT EXISTS susconecta;
USE susconecta;

-- Tabela Paciente
CREATE TABLE Paciente (
    id_paciente INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    data_nascimento DATE NOT NULL,
    cpf VARCHAR(45) NOT NULL UNIQUE,
    endereco VARCHAR(45),
    telefone VARCHAR(45),
    email VARCHAR(45)
);

-- Tabela hospital/clinica
CREATE TABLE hospital_clinica (
    id_hospital INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(45) NOT NULL,
    endereco VARCHAR(45),
    telefone VARCHAR(45)
);

-- Tabela medico
CREATE TABLE medico (
    id_medico INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(45) NOT NULL,
    crm VARCHAR(45) NOT NULL UNIQUE,
    especialidade VARCHAR(45),
    telefone VARCHAR(45),
    email VARCHAR(45),
    Paciente_id_paciente INT,
    FOREIGN KEY (Paciente_id_paciente) REFERENCES Paciente(id_paciente)
);

-- Tabela atendimento
CREATE TABLE atendimento (
    id_atendimento INT PRIMARY KEY AUTO_INCREMENT,
    medicamento VARCHAR(45),
    data_hora DATETIME NOT NULL,
    diagnostico TEXT(1000),
    prescricao VARCHAR(255),
    observacoes TEXT(1000),
    status ENUM('Agendado', 'Em Andamento', 'Concluído', 'Cancelado') NOT NULL,
    especialidades VARCHAR(100),
    Paciente_id_paciente INT NOT NULL,
    hospital_clinica_id_hospital INT NOT NULL,
    FOREIGN KEY (Paciente_id_paciente) REFERENCES Paciente(id_paciente),
    FOREIGN KEY (hospital_clinica_id_hospital) REFERENCES hospital_clinica(id_hospital)
);

-- Tabela exame
CREATE TABLE exame (
    id_exame INT PRIMARY KEY AUTO_INCREMENT,
    id_consulta VARCHAR(45),
    tipo VARCHAR(45),
    resultado VARCHAR(45),
    laboratorio VARCHAR(45),
    data VARCHAR(45),
    atendimento_id_atendimento INT NOT NULL,
    atendimento_Paciente_id_paciente INT NOT NULL,
    FOREIGN KEY (atendimento_id_atendimento) REFERENCES atendimento(id_atendimento),
    FOREIGN KEY (atendimento_Paciente_id_paciente) REFERENCES atendimento(Paciente_id_paciente)
);

-- Adicionando índices para melhor performance
CREATE INDEX idx_paciente_cpf ON Paciente(cpf);
CREATE INDEX idx_medico_crm ON medico(crm);
CREATE INDEX idx_atendimento_data ON atendimento(data_hora); 