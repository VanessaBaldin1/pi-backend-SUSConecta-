<?php
// Configurações do Banco de Dados
define('DB_HOST', 'localhost');
define('DB_NAME', 'conecta_consulta');
define('DB_USER', 'root');
define('DB_PASS', '');

// Configurações da Aplicação
define('APP_NAME', 'Conecta-Consulta');
define('APP_VERSION', '1.0.0');
define('APP_URL', 'http://localhost/pi-backend');

// Configurações de Email
define('SUPPORT_EMAIL', 'suporte@conectaconsulta.com');

// Configurações de Diretórios
define('ROOT_PATH', dirname(__DIR__, 2));
define('VIEWS_PATH', ROOT_PATH . '/views');
define('ASSETS_PATH', ROOT_PATH . '/assets');

// Configurações de Mensagens
define('MENSAGENS', [
    'sucesso' => [
        'criar' => 'Registro criado com sucesso!',
        'atualizar' => 'Registro atualizado com sucesso!',
        'excluir' => 'Registro excluído com sucesso!'
    ],
    'erro' => [
        'criar' => 'Erro ao criar registro.',
        'atualizar' => 'Erro ao atualizar registro.',
        'excluir' => 'Erro ao excluir registro.',
        'acao_invalida' => 'Ação inválida.'
    ]
]);

// Configurações de Status
define('STATUS_EXAME', [
    'agendado' => 'Agendado',
    'realizado' => 'Realizado',
    'cancelado' => 'Cancelado'
]); 