<?php
// Inclusão dos arquivos necessários
require_once __DIR__ . '/src/config/config.php';
require_once __DIR__ . '/src/Models/Exame.php';
require_once __DIR__ . '/src/Services/ExameService.php';
require_once __DIR__ . '/src/config/Database.php';
require_once __DIR__ . '/src/services/PacienteService.php';
require_once __DIR__ . '/src/services/MedicoService.php';

// Define a página atual para o menu
$paginaAtual = 'exame';

// Inicialização da conexão com o banco de dados
$database = new Database();
$conn = $database->getConnection();

// Criação do serviço de exames
$exameService = new ExameService($conn);
$pacienteService = new PacienteService($conn);
$medicoService = new MedicoService($conn);

// Variáveis para mensagens de feedback
$mensagem = '';
$tipoMensagem = '';

// Função para processar as ações do formulário
function processarAcao($exameService) {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['acao'])) {
        return ['mensagem' => '', 'tipo' => ''];
    }

    $dados = [
        'nome_paciente' => $_POST['paciente_id'] ?? '',
        'nome_medico' => $_POST['medico_id'] ?? '',
        'tipo_exame' => $_POST['tipo_exame'] ?? '',
        'data_exame' => $_POST['data_exame'] ?? '',
        'hora_exame' => $_POST['hora_exame'] ?? '',
        'resultado' => $_POST['resultado'] ?? '',
        'status' => $_POST['status'] ?? ''
    ];

    try {
        switch ($_POST['acao']) {
            case 'criar':
                $resultado = $exameService->criarExame($dados);
                return [
                    'mensagem' => MENSAGENS['sucesso']['criar'],
                    'tipo' => 'sucesso'
                ];

            case 'atualizar':
                $dados['id'] = $_POST['id'] ?? '';
                $resultado = $exameService->atualizarExame($dados);
                return [
                    'mensagem' => MENSAGENS['sucesso']['atualizar'],
                    'tipo' => 'sucesso'
                ];

            case 'excluir':
                $resultado = $exameService->excluirExame($_POST['id'] ?? '');
                return [
                    'mensagem' => MENSAGENS['sucesso']['excluir'],
                    'tipo' => 'sucesso'
                ];

            default:
                return [
                    'mensagem' => MENSAGENS['erro']['acao_invalida'],
                    'tipo' => 'erro'
                ];
        }
    } catch (Exception $e) {
        return [
            'mensagem' => MENSAGENS['erro'][$_POST['acao']] ?? 'Erro inesperado',
            'tipo' => 'erro'
        ];
    }
}

// Processa a ação e obtém o resultado
$resultado = processarAcao($exameService);
$mensagem = $resultado['mensagem'];
$tipoMensagem = $resultado['tipo'];

// Buscar exame para edição
$exame = null;
if (isset($_GET['id'])) {
    $exame = $exameService->buscarExame($_GET['id']);
}

// Obtém a lista de exames
$exames = $exameService->listarExames();

// Buscar pacientes e médicos para os selects
$pacientes = $pacienteService->listarPacientes()['records'];
$medicos = $medicoService->listarMedicos()['records'];

// Inclui o cabeçalho
require_once VIEWS_PATH . '/templates/header.php';
?>

<h2>Agendamento de Exames</h2>

<?php if ($mensagem): ?>
    <div class="mensagem <?php echo $tipoMensagem; ?>">
        <?php echo $mensagem; ?>
        <button class="fechar-mensagem">&times;</button>
    </div>
<?php endif; ?>

<!-- Formulário de cadastro/edição -->
<div class="card">
    <form class="formulario" method="POST" id="formExame">
        <?php if (isset($exame)): ?>
            <input type="hidden" name="acao" value="atualizar">
            <input type="hidden" name="id" value="<?php echo $exame['id']; ?>">
        <?php else: ?>
            <input type="hidden" name="acao" value="criar">
        <?php endif; ?>

        <div class="form-grid">
            <!-- Campos do formulário -->
            <div class="form-group">
                <label for="paciente_id">Paciente:</label>
                <select id="paciente_id" name="paciente_id" required>
                    <option value="">Selecione um paciente</option>
                    <?php foreach ($pacientes as $paciente): ?>
                        <option value="<?php echo htmlspecialchars($paciente['id']); ?>" 
                                <?php echo (isset($exame) && $exame['nome_paciente'] === $paciente['nome']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($paciente['nome']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="medico_id">Médico:</label>
                <select id="medico_id" name="medico_id" required>
                    <option value="">Selecione um médico</option>
                    <?php foreach ($medicos as $medico): ?>
                        <option value="<?php echo htmlspecialchars($medico['id']); ?>"
                                <?php echo (isset($exame) && $exame['nome_medico'] === $medico['nome']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($medico['nome']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="tipo_exame">Tipo de Exame:</label>
                <select id="tipo_exame" name="tipo_exame" required>
                    <option value="">Selecione o tipo de exame</option>
                    <option value="Raio-X" <?php echo (isset($exame) && $exame['tipo_exame'] === 'Raio-X') ? 'selected' : ''; ?>>Raio-X</option>
                    <option value="Ultrassom" <?php echo (isset($exame) && $exame['tipo_exame'] === 'Ultrassom') ? 'selected' : ''; ?>>Ultrassom</option>
                    <option value="Tomografia" <?php echo (isset($exame) && $exame['tipo_exame'] === 'Tomografia') ? 'selected' : ''; ?>>Tomografia</option>
                    <option value="Ressonância" <?php echo (isset($exame) && $exame['tipo_exame'] === 'Ressonância') ? 'selected' : ''; ?>>Ressonância</option>
                    <option value="Exame de Sangue" <?php echo (isset($exame) && $exame['tipo_exame'] === 'Exame de Sangue') ? 'selected' : ''; ?>>Exame de Sangue</option>
                </select>
            </div>

            <div class="form-group">
                <label for="data_exame">Data do Exame:</label>
                <input type="date" id="data_exame" name="data_exame" required value="<?php echo isset($exame) ? htmlspecialchars($exame['data_exame']) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="hora_exame">Hora do Exame:</label>
                <input type="time" id="hora_exame" name="hora_exame" required value="<?php echo isset($exame) ? htmlspecialchars($exame['hora_exame']) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option value="">Selecione o status</option>
                    <?php foreach (STATUS_EXAME as $valor => $label): ?>
                        <option value="<?php echo $valor; ?>" <?php echo (isset($exame) && $exame['status'] === $valor) ? 'selected' : ''; ?>><?php echo $label; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="resultado">Resultado:</label>
                <textarea id="resultado" name="resultado" rows="3"><?php echo isset($exame) ? htmlspecialchars($exame['resultado']) : ''; ?></textarea>
            </div>
        </div>

        <!-- Botões do formulário -->
        <div class="form-buttons">
            <?php if (isset($exame)): ?>
                <button type="submit" class="btn-primary">Atualizar Exame</button>
                <button type="button" class="btn-secondary" onclick="ExameManager.limparFormulario()">Cancelar</button>
            <?php else: ?>
                <button type="submit" class="btn-primary">Agendar Exame</button>
                <button type="button" class="btn-secondary" onclick="ExameManager.limparFormulario()">Limpar</button>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- Lista de exames -->
<div class="card">
    <h3>Exames Agendados</h3>
    <div class="table-responsive">
        <table class="tabela">
            <thead>
                <tr>
                    <th>Paciente</th>
                    <th>Médico</th>
                    <th>Tipo</th>
                    <th>Data</th>
                    <th>Hora</th>
                    <th>Status</th>
                    <th>Resultado</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($exames['records'] as $exame): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($exame['nome_paciente']); ?></td>
                        <td><?php echo htmlspecialchars($exame['nome_medico']); ?></td>
                        <td><?php echo htmlspecialchars($exame['tipo_exame']); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($exame['data_exame'])); ?></td>
                        <td><?php echo date('H:i', strtotime($exame['hora_exame'])); ?></td>
                        <td><?php echo htmlspecialchars($exame['status']); ?></td>
                        <td><?php echo htmlspecialchars($exame['resultado']); ?></td>
                        <td class="acoes">
                            <button class="btn-icon" 
                                    onclick="ExameManager.editarExame(<?php echo htmlspecialchars(json_encode($exame)); ?>)" 
                                    title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon btn-danger" 
                                    onclick="ExameManager.confirmarExclusao(<?php echo $exame['id']; ?>, '<?php echo htmlspecialchars($exame['nome_paciente']); ?>')" 
                                    title="Excluir">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal de confirmação de exclusão -->
<div id="modalExclusao" class="modal">
    <div class="modal-content">
        <h3>Confirmar Exclusão</h3>
        <p>Tem certeza que deseja excluir o exame do paciente <span id="nomePacienteExclusao"></span>?</p>
        <form method="POST">
            <input type="hidden" name="acao" value="excluir">
            <input type="hidden" name="id" id="idExclusao">
            <div class="modal-buttons">
                <button type="submit" class="btn-danger">Confirmar Exclusão</button>
                <button type="button" class="btn-secondary" onclick="ExameManager.fecharModal()">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<?php
// Inclui o rodapé
require_once VIEWS_PATH . '/templates/footer.php';
?> 