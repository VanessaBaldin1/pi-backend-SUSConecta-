<?php
require_once __DIR__ . '/src/config/Database.php';
require_once __DIR__ . '/src/services/ConsultaService.php';
require_once __DIR__ . '/src/services/PacienteService.php';
require_once __DIR__ . '/src/services/MedicoService.php';
require_once __DIR__ . '/src/services/ExameService.php';

$database = new Database();
$conn = $database->getConnection();

$consultaService = new ConsultaService($conn);
$pacienteService = new PacienteService($conn);
$medicoService = new MedicoService;
$exameService = new ExameService($conn);

$consultas = $consultaService->listarConsultas()['records'];
$medicos = $medicoService->listarMedicos()['records'];
$exames = $exameService->listarExames()['records'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Conecta-Consulta</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
  <nav>
    <div class="logo">
      <img src="imagens/logotipo.png" alt="Logo Conecta-Consulta">
      Conecta-Consulta
    </div>
    <ul>
      <li><a href="index.php" class="active">Início</a></li>
      <li><a href="consulta.php">Consulta</a></li>
      <li><a href="exame.php">Exame</a></li>
      <li><a href="medico.php">Médico</a></li>
      <li><a href="paciente.php">Paciente</a></li>
    </ul>
  </nav>
  <main>
    <section class="container">
      <h2>Dashboard</h2>
      
      <div class="dashboard-grid">
        <div class="dashboard-card">
          <h3>Consultas</h3>
          <p class="numero"><?php echo count($consultas); ?></p>
          <a href="consulta.php" class="btn-link">Ver todos</a>
        </div>

        <div class="dashboard-card">
          <h3>Pacientes</h3>
          <p class="numero"><?php echo count($pacientes); ?></p>
          <a href="paciente.php" class="btn-link">Ver todos</a>
        </div>

        <div class="dashboard-card">
          <h3>Médicos</h3>
          <p class="numero"><?php echo count($medicos); ?></p>
          <a href="medico.php" class="btn-link">Ver todos</a>
        </div>

        <div class="dashboard-card">
          <h3>Exames</h3>
          <p class="numero"><?php echo count($exames); ?></p>
          <a href="exame.php" class="btn-link">Ver todos</a>
        </div>
      </div>

      <h3>Últimas Consultas</h3>
      <table class="tabela">
        <thead>
          <tr>
            <th>Data</th>
            <th>Paciente</th>
            <th>Médico</th>
            <th>Status</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach (array_slice($consultas, 0, 5) as $consulta): ?>
          <tr>
            <td><?php echo date('d/m/Y', strtotime($consulta['data_consulta'])); ?></td>
            <td><?php echo htmlspecialchars($consulta['nome_paciente']); ?></td>
            <td><?php echo htmlspecialchars($consulta['nome_medico']); ?></td>
            <td><?php echo htmlspecialchars($consulta['tipo_consulta']); ?></td>
            <td class="acoes">
                <a href="consulta.php?id=<?php echo $consulta['id']; ?>" class="btn-icon" title="Editar">
                    <i class="fas fa-edit"></i>
                </a>
                <button class="btn-icon btn-danger" onclick="confirmarExclusao(<?php echo $consulta['id']; ?>, '<?php echo htmlspecialchars($consulta['nome_paciente']); ?>')" title="Excluir">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </section>
  </main>

  <!-- Modal de Confirmação de Exclusão -->
  <div id="modalExclusao" class="modal">
    <div class="modal-content">
      <h3>Confirmar Exclusão</h3>
      <p>Tem certeza que deseja excluir a consulta do paciente <span id="nomePacienteExclusao"></span>?</p>
      <form method="POST" action="consulta.php">
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