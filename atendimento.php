<?php
require_once __DIR__ . '/src/Models/Consulta.php';
require_once __DIR__ . '/src/Services/ConsultaService.php';
require_once __DIR__ . '/src/config/Database.php';

$database = new Database();
$db = $database->getConnection();

$consultaService = new ConsultaService($db);

$mensagem = '';
$tipoMensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'create':
                $dados = [
                    'paciente_id' => $_POST['paciente_id'],
                    'medico_id' => $_POST['medico_id'],
                    'data_consulta' => $_POST['data_consulta'],
                    'hora_consulta' => $_POST['hora_consulta'],
                    'tipo_consulta' => $_POST['tipo_consulta'],
                    'observacoes' => $_POST['observacoes']
                ];
                $resultado = $consultaService->criarConsulta($dados);
                break;

            case 'update':
                $dados = [
                    'id' => $_POST['id'],
                    'paciente_id' => $_POST['paciente_id'],
                    'medico_id' => $_POST['medico_id'],
                    'data_consulta' => $_POST['data_consulta'],
                    'hora_consulta' => $_POST['hora_consulta'],
                    'tipo_consulta' => $_POST['tipo_consulta'],
                    'observacoes' => $_POST['observacoes']
                ];
                $resultado = $consultaService->atualizarConsulta($dados);
                break;

            case 'delete':
                $resultado = $consultaService->excluirConsulta($_POST['id']);
                break;
        }
        
        $mensagem = $resultado['message'];
        $tipoMensagem = $resultado['status'];
    }
}

$consultas = $consultaService->listarConsultas();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultas - Conecta-Consulta</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .btn-icon {
            background: none;
            border: none;
            cursor: pointer;
            padding: 5px;
            margin: 0 2px;
            font-size: 1.1em;
            color: #2196F3;
            transition: color 0.3s;
        }
        .btn-icon:hover {
            color: #1976D2;
        }
        .btn-icon.btn-danger {
            color: #f44336;
        }
        .btn-icon.btn-danger:hover {
            color: #d32f2f;
        }
        .acoes {
            display: flex;
            justify-content: center;
            gap: 5px;
        }
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            width: 90%;
            max-width: 500px;
        }
        .modal-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <nav>
        <div class="logo">
            <img src="imagens/logotipo.png" alt="Logo Conecta-Consulta">
            Conecta-Consulta
        </div>
        <ul>
            <li><a href="index.php">Início</a></li>
            <li><a href="consulta.php" class="active">Consulta</a></li>
            <li><a href="exame.php">Exame</a></li>
            <li><a href="medico.php">Médico</a></li>
            <li><a href="paciente.php">Paciente</a></li>
        </ul>
    </nav>
    <main>
        <section class="container">
            <h2>Agendamento de Consultas</h2>

            <?php if ($mensagem): ?>
                <div class="mensagem <?php echo $tipoMensagem; ?>">
                    <?php echo $mensagem; ?>
                    <button class="fechar-mensagem">&times;</button>
                </div>
            <?php endif; ?>

            <div class="card">
                <form class="formulario" method="POST" id="formConsulta">
                    <input type="hidden" name="action" value="create">
                    <input type="hidden" name="id" id="id">

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="paciente_id">Paciente:</label>
                            <select id="paciente_id" name="paciente_id" required>
                                <option value="">Selecione um paciente</option>
                                <?php foreach ($pacientes as $paciente): ?>
                                    <option value="<?php echo $paciente['id']; ?>">
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
                                    <option value="<?php echo $medico['id']; ?>">
                                        <?php echo htmlspecialchars($medico['nome']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="data_consulta">Data da Consulta:</label>
                            <input type="date" id="data_consulta" name="data_consulta" required>
                        </div>

                        <div class="form-group">
                            <label for="hora_consulta">Hora da Consulta:</label>
                            <input type="time" id="hora_consulta" name="hora_consulta" required>
                        </div>

                        <div class="form-group">
                            <label for="tipo_consulta">Tipo de Consulta:</label>
                            <select id="tipo_consulta" name="tipo_consulta" required>
                                <option value="consulta">Consulta</option>
                                <option value="retorno">Retorno</option>
                                <option value="emergencia">Emergência</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="observacoes">Observações:</label>
                            <textarea id="observacoes" name="observacoes" rows="4"></textarea>
                        </div>
                    </div>

                    <div class="form-buttons">
                        <button type="submit" class="btn-primary">Agendar Consulta</button>
                        <button type="button" class="btn-secondary" onclick="limparFormulario()">Limpar</button>
                    </div>
                </form>
            </div>

            <div class="card">
                <h3>Consultas Agendadas</h3>
                <div class="table-responsive">
                    <table class="tabela">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Hora</th>
                                <th>Paciente</th>
                                <th>Médico</th>
                                <th>Tipo</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($consultas as $consulta): ?>
                                <tr>
                                    <td><?php echo date('d/m/Y', strtotime($consulta['data_consulta'])); ?></td>
                                    <td><?php echo date('H:i', strtotime($consulta['hora_consulta'])); ?></td>
                                    <td><?php echo htmlspecialchars($consulta['nome_paciente']); ?></td>
                                    <td><?php echo htmlspecialchars($consulta['nome_medico']); ?></td>
                                    <td><?php echo htmlspecialchars($consulta['tipo_consulta']); ?></td>
                                    <td class="acoes">
                                        <button class="btn-icon" onclick="editarConsulta(<?php echo htmlspecialchars(json_encode($consulta)); ?>)" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn-icon btn-danger" onclick="excluirConsulta(<?php echo $consulta['id']; ?>)" title="Excluir">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>

    <!-- Modal de Confirmação de Exclusão -->
    <div id="modalExclusao" class="modal">
        <div class="modal-content">
            <h3>Confirmar Exclusão</h3>
            <p>Tem certeza que deseja excluir esta consulta?</p>
            <form method="POST">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" id="idExclusao">
                <div class="modal-buttons">
                    <button type="submit" class="btn-danger">Confirmar Exclusão</button>
                    <button type="button" class="btn-secondary" onclick="fecharModal()">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <footer>
        <img src="imagens/logotipo.png" alt="Logo Conecta-Consulta">
        <p>&copy; 2025 Conecta-Consulta. Todos os direitos reservados.</p>
        <p>Suporte: suporte@conectaconsulta.com</p>
    </footer>

    <script>
        // Função para editar consulta
        function editarConsulta(consulta) {
            document.getElementById('id').value = consulta.id;
            document.getElementById('paciente_id').value = consulta.paciente_id;
            document.getElementById('medico_id').value = consulta.medico_id;
            document.getElementById('data_consulta').value = consulta.data_consulta;
            document.getElementById('hora_consulta').value = consulta.hora_consulta;
            document.getElementById('tipo_consulta').value = consulta.tipo_consulta;
            document.getElementById('observacoes').value = consulta.observacoes;
            
            document.querySelector('input[name="action"]').value = 'update';
            document.querySelector('.btn-primary').textContent = 'Atualizar Consulta';
            
            // Scroll suave até o formulário
            document.querySelector('.formulario').scrollIntoView({ behavior: 'smooth' });
        }

        // Função para excluir consulta
        function excluirConsulta(id) {
            document.getElementById('idExclusao').value = id;
            document.getElementById('modalExclusao').style.display = 'flex';
        }

        // Função para fechar modal
        function fecharModal() {
            document.getElementById('modalExclusao').style.display = 'none';
        }

        // Fechar mensagens de alerta
        document.querySelectorAll('.fechar-mensagem').forEach(button => {
            button.addEventListener('click', function() {
                this.parentElement.style.display = 'none';
            });
        });

        // Fechar modal ao clicar fora
        window.onclick = function(event) {
            if (event.target == document.getElementById('modalExclusao')) {
                fecharModal();
            }
        }

        // Função para limpar formulário
        function limparFormulario() {
            document.getElementById('formConsulta').reset();
            document.getElementById('id').value = '';
            document.querySelector('input[name="action"]').value = 'create';
            document.querySelector('.btn-primary').textContent = 'Agendar Consulta';
        }
    </script>
</body>
</html> 