<?php
require_once __DIR__ . '/src/Models/Atendimento.php';
require_once __DIR__ . '/src/Services/AtendimentoService.php';
require_once __DIR__ . '/src/config/Database.php';

try {
    // Teste de conexão
    $database = new Database();
    $db = $database->getConnection();
    echo "Conexão com o banco de dados estabelecida com sucesso!<br>";

    // Teste do serviço
    $atendimentoService = new AtendimentoService($db);

    // Teste de criação
    $dados = [
        'paciente_id' => 'João Silva',
        'medico_id' => 'Dr. Carlos',
        'data_atendimento' => '2024-03-20',
        'hora_atendimento' => '14:30',
        'tipo_atendimento' => 'consulta',
        'observacoes' => 'Teste de atendimento'
    ];

    $resultado = $atendimentoService->criarAtendimento($dados);
    echo "Resultado da criação: " . $resultado['message'] . "<br>";

    // Teste de listagem
    $atendimentos = $atendimentoService->listarAtendimentos();
    echo "Total de atendimentos: " . count($atendimentos) . "<br>";
    echo "<pre>";
    print_r($atendimentos);
    echo "</pre>";

} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
} 