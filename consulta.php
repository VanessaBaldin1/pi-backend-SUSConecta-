<?php
require_once __DIR__ . '/src/Models/Consulta.php';
require_once __DIR__ . '/src/Services/ConsultaService.php';
require_once __DIR__ . '/src/Services/MedicoService.php';
require_once __DIR__ . '/src/Services/PacienteService.php';
require_once __DIR__ . '/src/config/Database.php';

$database = new Database();
$db = $database->getConnection();

$consultaService = new ConsultaService();
$medicoService = new MedicoService();
$pacienteService = new PacienteService();

$mensagem = '';
$tipoMensagem = '';

// Carregar dados para as listas suspensas
$medicos = $medicoService->getAll();
$pacientes = $pacienteService->getAll();

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
                if($consultaService->create($dados)) {
                    $mensagem = "Consulta criada com sucesso.";
                    $tipoMensagem = "success";
                } else {
                    $mensagem = "Erro ao criar consulta.";
                    $tipoMensagem = "danger";
                }
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
                if($consultaService->update($dados)) {
                    $mensagem = "Consulta atualizada com sucesso.";
                    $tipoMensagem = "success";
                } else {
                    $mensagem = "Erro ao atualizar consulta.";
                    $tipoMensagem = "danger";
                }
                break;

            case 'delete':
                if($consultaService->delete($_POST['id'])) {
                    $mensagem = "Consulta excluída com sucesso.";
                    $tipoMensagem = "success";
                } else {
                    $mensagem = "Erro ao excluir consulta.";
                    $tipoMensagem = "danger";
                }
                break;
        }
    }
}

$consultas = $consultaService->getAll();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Consultas - Conecta-Consulta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
        <h2>Gerenciamento de Consultas</h2>
        
        <?php if($mensagem): ?>
        <div class="alert alert-<?php echo $tipoMensagem; ?> alert-dismissible fade show" role="alert">
            <?php echo $mensagem; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>

        <div class="formulario">
            <form method="POST" class="mb-4">
                <input type="hidden" name="action" value="create">
                <input type="hidden" name="id" id="consulta_id">
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="paciente_id" class="form-label">Paciente</label>
                        <select class="form-select" name="paciente_id" id="paciente_id" required>
                            <option value="">Selecione um paciente</option>
                            <?php if(isset($pacientes['records']) && !empty($pacientes['records'])): ?>
                                <?php foreach($pacientes['records'] as $paciente): ?>
                                    <option value="<?php echo $paciente['id']; ?>">
                                        <?php echo htmlspecialchars($paciente['nome']) . ' - CPF: ' . htmlspecialchars($paciente['cpf']); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="medico_id" class="form-label">Médico</label>
                        <select class="form-select" name="medico_id" id="medico_id" required>
                            <option value="">Selecione um médico</option>
                            <?php if(isset($medicos['records']) && !empty($medicos['records'])): ?>
                                <?php foreach($medicos['records'] as $medico): ?>
                                    <option value="<?php echo $medico['id']; ?>">
                                        <?php echo htmlspecialchars($medico['nome']) . ' - ' . htmlspecialchars($medico['especialidade']); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="data_consulta" class="form-label">Data da Consulta</label>
                        <input type="text" class="form-control" name="data_consulta" id="data_consulta" placeholder="DD/MM/AAAA" required>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label for="hora_consulta" class="form-label">Hora da Consulta</label>
                        <input type="text" class="form-control" name="hora_consulta" id="hora_consulta" placeholder="HH:MM" required>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label for="tipo_consulta" class="form-label">Tipo de Consulta</label>
                        <select class="form-select" name="tipo_consulta" id="tipo_consulta" required>
                            <option value="">Selecione o tipo</option>
                            <option value="consulta">Primeira Consulta</option>
                            <option value="retorno">Retorno</option>
                            <option value="emergencia">Emergência</option>
                        </select>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="observacoes" class="form-label">Observações</label>
                    <textarea class="form-control" name="observacoes" id="observacoes" rows="3" placeholder="Digite as observações da consulta"></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary">Salvar Consulta</button>
            </form>
        </div>
        
        <div class="table-responsive">
            <table class="tabela">
                <thead>
                    <tr>
                        <th>Paciente</th>
                        <th>Médico</th>
                        <th>Data</th>
                        <th>Hora</th>
                        <th>Tipo</th>
                        <th>Observações</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($consultas['records'] as $consulta): ?>
                    <tr>
                        <td><?php echo $consulta['nome_paciente']; ?></td>
                        <td><?php echo $consulta['nome_medico']; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($consulta['data_consulta'])); ?></td>
                        <td><?php echo $consulta['hora_consulta']; ?></td>
                        <td><?php echo ucfirst($consulta['tipo_consulta']); ?></td>
                        <td><?php echo $consulta['observacoes'] ?: '-'; ?></td>
                        <td class="acoes">
                            <button class="btn-icon" onclick="editarConsulta(<?php echo htmlspecialchars(json_encode($consulta)); ?>)" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon btn-danger" onclick="confirmarExclusao(<?php echo $consulta['id']; ?>, '<?php echo htmlspecialchars($consulta['nome_paciente']); ?>')" title="Excluir">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
  </main>

  <!-- Modal de Confirmação de Exclusão -->
  <div id="modalExclusao" class="modal">
    <div class="modal-content">
      <h3>Confirmar Exclusão</h3>
      <p>Tem certeza que deseja excluir a consulta do paciente <span id="nomePacienteExclusao"></span>?</p>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Máscara para data
    document.getElementById('data_consulta').addEventListener('input', function(e) {
      let value = e.target.value.replace(/\D/g, '');
      if (value.length <= 8) {
        value = value.replace(/(\d{2})(\d)/, '$1/$2');
        value = value.replace(/(\d{2})(\d)/, '$1/$2');
        e.target.value = value;
      }
    });

    // Máscara para hora
    document.getElementById('hora_consulta').addEventListener('input', function(e) {
      let value = e.target.value.replace(/\D/g, '');
      if (value.length <= 4) {
        value = value.replace(/(\d{2})(\d)/, '$1:$2');
        e.target.value = value;
      }
    });

    // Função para editar consulta
    function editarConsulta(consulta) {
      document.getElementById('consulta_id').value = consulta.id;
      document.getElementById('paciente_id').value = consulta.paciente_id;
      document.getElementById('medico_id').value = consulta.medico_id;
      
      // Formata a data para o formato brasileiro
      let data = new Date(consulta.data_consulta);
      let dataFormatada = data.toLocaleDateString('pt-BR');
      document.getElementById('data_consulta').value = dataFormatada;
      
      document.getElementById('hora_consulta').value = consulta.hora_consulta;
      document.getElementById('tipo_consulta').value = consulta.tipo_consulta;
      document.getElementById('observacoes').value = consulta.observacoes;
      
      document.querySelector('input[name="action"]').value = 'update';
      document.querySelector('.btn-primary').textContent = 'Atualizar Consulta';
    }

    // Função para limpar formulário
    function limparFormulario() {
      document.getElementById('consulta_id').value = '';
      document.getElementById('paciente_id').value = '';
      document.getElementById('medico_id').value = '';
      document.getElementById('data_consulta').value = '';
      document.getElementById('hora_consulta').value = '';
      document.getElementById('tipo_consulta').value = '';
      document.getElementById('observacoes').value = '';
      
      document.querySelector('input[name="action"]').value = 'create';
      document.querySelector('.btn-primary').textContent = 'Salvar Consulta';
    }

    // Função para confirmar exclusão
    function confirmarExclusao(id, nome) {
      document.getElementById('idExclusao').value = id;
      document.getElementById('nomePacienteExclusao').textContent = nome;
      document.getElementById('modalExclusao').style.display = 'flex';
    }

    // Função para fechar modal
    function fecharModal() {
      document.getElementById('modalExclusao').style.display = 'none';
    }

    // Fechar modal ao clicar fora
    window.onclick = function(event) {
      if (event.target == document.getElementById('modalExclusao')) {
        fecharModal();
      }
    }
    </script>
</body>
</html> 