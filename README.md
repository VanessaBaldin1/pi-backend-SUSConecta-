# Projeto Integrado – **SUS-Conecta**
*Senac Penha - Curso Técnico em Informática para Internet*

## 1. Descrição do Projeto

O **SUS-Conecta** é uma plataforma digital desenvolvida para otimizar a comunicação entre cidadãos, profissionais da saúde e serviços de saúde pública no Brasil. O sistema visa proporcionar um acesso mais fácil a informações de saúde, agendamento de consultas, exames e outros serviços relacionados ao Sistema Único de Saúde (SUS). A plataforma integra as funcionalidades de um sistema backend robusto e uma API eficiente.

## 2. Motivação

O objetivo principal do projeto é melhorar a acessibilidade e a gestão dos serviços de saúde pública, proporcionando uma plataforma digital onde os cidadãos podem agendar consultas, acessar seus históricos médicos e obter informações essenciais sobre campanhas de saúde. O **SUS-Conecta** busca facilitar o uso dos serviços do SUS, trazendo mais eficiência e praticidade para o público.

## 3. Acessibilidade

O **SUS-Conecta** estará disponível como uma plataforma responsiva, permitindo acesso tanto por desktop quanto por dispositivos móveis (smartphones e tablets). Isso garante que os cidadãos possam acessar os serviços a qualquer momento e de qualquer lugar, facilitando o processo de agendamento e acompanhamento de saúde.

## 4. Tecnologias Utilizadas

O sistema será desenvolvido com a seguinte stack tecnológica:

- **Frontend:** HTML, CSS, JavaScript
- **Backend:** Node.js, Express, MySQL
- **Funcionalidades:**
  - Sistema de agendamento de consultas e exames
  - Acesso a históricos médicos e dados de saúde
  - Notificações de campanhas de vacinação e saúde pública
  - Integração de APIs para otimizar a comunicação entre cidadãos e profissionais de saúde

## 5. Público-Alvo

O **SUS-Conecta** é voltado para cidadãos que desejam acessar e utilizar os serviços do Sistema Único de Saúde (SUS), além de profissionais da saúde que necessitam de ferramentas para otimizar o atendimento. O sistema também atende à gestão de serviços de saúde pública, buscando melhorar a eficiência dos processos.

## 6. Funcionalidades

- **Agendamento de Consultas:** Permite agendar consultas e exames com facilidade.
- **Histórico Médico:** Acesso a dados de saúde e informações médicas.
- **Notificações de Saúde:** Alertas sobre campanhas de vacinação e saúde pública.
- **Plataforma Responsiva:** Acesso via desktop, smartphone e tablet.

## 7. Como Usar

1. Acesse o site ou plataforma do **SUS-Conecta** em qualquer dispositivo.
2. Realize login utilizando a sua conta do SUS ou crie uma conta nova.
3. Agende consultas ou exames conforme necessário.
4. Acesse o histórico médico e receba notificações de saúde pública diretamente na plataforma.

## 8. Equipe

- **Heloisa Bussi**
- **Marcio Bazão**
- **Vanessa Baldin**

## 9. Modelagem Conceitual do Banco de Dados

A modelagem conceitual do banco de dados pode ser visualizada através do seguinte link:

![Modelagem Conceitual do Banco de Dados](/modelagem_conceitual/PI-modelo-conceitua2l%201..png)

# Conecta-Consulta

Sistema de gerenciamento de consultas médicas desenvolvido em PHP com MySQL.

## Requisitos

- PHP 7.4 ou superior
- MySQL 5.7 ou superior
- Servidor web (Apache/Nginx)

## Instalação

1. Clone o repositório:
```bash
git clone https://github.com/seu-usuario/conecta-consulta.git
cd conecta-consulta
```

2. Configure o banco de dados:
- Crie um banco de dados MySQL
- Importe o arquivo `src/config/database.sql` para criar as tabelas necessárias
- Configure as credenciais do banco de dados no arquivo `src/config/Database.php`

3. Configure o servidor web:
- Aponte o DocumentRoot para a pasta do projeto
- Certifique-se de que o mod_rewrite está habilitado (Apache)
- Configure as permissões corretas para os arquivos

4. Instale as dependências (se houver):
```bash
composer install
```

## Estrutura do Projeto

```
conecta-consulta/
├── src/
│   ├── config/
│   │   ├── Database.php
│   │   └── database.sql
│   ├── models/
│   │   ├── Atendimento.php
│   │   ├── Medico.php
│   │   └── Paciente.php
│   └── services/
│       ├── AtendimentoService.php
│       ├── MedicoService.php
│       └── PacienteService.php
├── css/
│   └── style.css
├── imagens/
├── atendimento.php
├── medico.php
├── paciente.php
└── index.php
```

## Funcionalidades

- Cadastro e gerenciamento de pacientes
- Cadastro e gerenciamento de médicos
- Agendamento de consultas
- Registro de atendimentos
- Gerenciamento de exames

## Segurança

- Todas as entradas de usuário são sanitizadas
- Uso de prepared statements para queries SQL
- Proteção contra SQL Injection
- Validação de dados

## Contribuição

1. Faça um fork do projeto
2. Crie uma branch para sua feature (`git checkout -b feature/nova-feature`)
3. Commit suas mudanças (`git commit -m 'Adiciona nova feature'`)
4. Push para a branch (`git push origin feature/nova-feature`)
5. Abra um Pull Request

## Licença

Este projeto está licenciado sob a licença MIT - veja o arquivo [LICENSE](LICENSE) para detalhes.

## Suporte

Para suporte, envie um email para suporte@conectaconsulta.com


