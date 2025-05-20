<?php

require_once __DIR__ . '/src/services/PacienteService.php';

$pacienteService = new PacienteService();
$mensagem = '';
$tipoMensagem = '';
$paginaAtual = 'paciente';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['acao'])) {
        switch ($_POST['acao']) {
            case 'criar':
                $dados = [
                    'nome' => $_POST['nome'],
                    'cpf' => $_POST['cpf'],
                    'data_nascimento' => $_POST['data_nascimento'],
                    'telefone' => $_POST['telefone'],
                    'email' => $_POST['email'],
                    'endereco' => $_POST['endereco']
                ];
                $resultado = $pacienteService->create($dados);
                $mensagem = $resultado['message'];
                $tipoMensagem = $resultado['status'];
                break;
            
            case 'atualizar':
                $dados = [
                    'id' => $_POST['id'],
                    'nome' => $_POST['nome'],
                    'cpf' => $_POST['cpf'],
                    'data_nascimento' => $_POST['data_nascimento'],
                    'telefone' => $_POST['telefone'],
                    'email' => $_POST['email'],
                    'endereco' => $_POST['endereco']
                ];
                $resultado = $pacienteService->update($dados);
                $mensagem = $resultado['message'];
                $tipoMensagem = $resultado['status'];
                break;
            
            case 'excluir':
                $resultado = $pacienteService->delete($_POST['id']);
                $mensagem = $resultado['message'];
                $tipoMensagem = $resultado['status'];
                break;
        }
    }
}

$pacientes = $pacienteService->getAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pacientes - Conecta-Consulta</title>
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
      <li><a href="index.php">Início</a></li>
      <li><a href="consulta.php">Consulta</a></li>
      <li><a href="exame.php">Exame</a></li>
      <li><a href="medico.php">Médico</a></li>
      <li><a href="paciente.php" class="active">Paciente</a></li>
    </ul>
  </nav>
  <main>
    <section class="container">
      <h2>Cadastro de Pacientes</h2>
      
      <?php if ($mensagem): ?>
        <div class="mensagem <?php echo $tipoMensagem; ?>">
          <?php echo $mensagem; ?>
          <button class="fechar-mensagem">&times;</button>
        </div>
      <?php endif; ?>

      <div class="card">
        <form class="formulario" method="POST" id="formPaciente">
          <input type="hidden" name="acao" value="criar">
          <input type="hidden" name="id" id="id" value="">
          
          <div class="form-grid">
            <div class="form-group">
              <label for="nome">Nome Completo:</label>
              <input type="text" id="nome" name="nome" required>
            </div>

            <div class="form-group">
              <label for="cpf">CPF:</label>
              <input type="text" id="cpf" name="cpf" required>
            </div>

            <div class="form-group">
              <label for="data_nascimento">Data de Nascimento:</label>
              <input type="date" id="data_nascimento" name="data_nascimento" required>
            </div>

            <div class="form-group">
              <label for="telefone">Telefone:</label>
              <input type="tel" id="telefone" name="telefone" required>
            </div>

            <div class="form-group">
              <label for="email">E-mail:</label>
              <input type="email" id="email" name="email">
            </div>

            <div class="form-group">
              <label for="endereco">Endereço:</label>
              <input type="text" id="endereco" name="endereco" required>
            </div>
          </div>

          <div class="form-buttons">
            <button type="submit" class="btn-primary">Cadastrar Paciente</button>
            <button type="button" class="btn-secondary" onclick="limparFormulario()">Limpar</button>
          </div>
        </form>
      </div>

      <div class="card">
        <h3>Pacientes Cadastrados</h3>
        <div class="table-responsive">
          <table class="tabela">
            <thead>
              <tr>
                <th>Nome</th>
                <th>CPF</th>
                <th>Data Nasc.</th>
                <th>Telefone</th>
                <th>E-mail</th>
                <th>Endereço</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php if(isset($pacientes['records']) && !empty($pacientes['records'])): ?>
                <?php foreach ($pacientes['records'] as $paciente): ?>
                <tr>
                    <td><?php echo htmlspecialchars($paciente['nome']); ?></td>
                    <td><?php echo htmlspecialchars($paciente['cpf']); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($paciente['data_nascimento'])); ?></td>
                    <td><?php echo htmlspecialchars($paciente['telefone']); ?></td>
                    <td><?php echo htmlspecialchars($paciente['email']); ?></td>
                    <td><?php echo htmlspecialchars($paciente['endereco']); ?></td>
                    <td class="acoes">
                        <button class="btn-icon" onclick="editarPaciente(<?php echo htmlspecialchars(json_encode($paciente)); ?>)" title="Editar">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-icon btn-danger" onclick="confirmarExclusao(<?php echo $paciente['id']; ?>, '<?php echo htmlspecialchars($paciente['nome']); ?>')" title="Excluir">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">Nenhum paciente cadastrado.</td>
                </tr>
              <?php endif; ?>
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
      <p>Tem certeza que deseja excluir o paciente <span id="nomePacienteExclusao"></span>?</p>
      <form method="POST">
        <input type="hidden" name="acao" value="excluir">
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
    // Função para editar paciente
    function editarPaciente(paciente) {
      document.getElementById('id').value = paciente.id;
      document.getElementById('nome').value = paciente.nome;
      document.getElementById('cpf').value = paciente.cpf;
      document.getElementById('data_nascimento').value = paciente.data_nascimento;
      document.getElementById('telefone').value = paciente.telefone;
      document.getElementById('email').value = paciente.email;
      document.getElementById('endereco').value = paciente.endereco;
      
      document.querySelector('input[name="acao"]').value = 'atualizar';
      document.querySelector('.btn-primary').textContent = 'Atualizar Paciente';
      
      // Scroll suave até o formulário
      document.querySelector('.formulario').scrollIntoView({ behavior: 'smooth' });
    }

    // Função para limpar formulário
    function limparFormulario() {
      document.getElementById('formPaciente').reset();
      document.getElementById('id').value = '';
      document.querySelector('input[name="acao"]').value = 'criar';
      document.querySelector('.btn-primary').textContent = 'Cadastrar Paciente';
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

    // Máscara para CPF
    document.getElementById('cpf').addEventListener('input', function(e) {
      let value = e.target.value.replace(/\D/g, '');
      if (value.length <= 11) {
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        e.target.value = value;
      }
    });

    // Máscara para telefone
    document.getElementById('telefone').addEventListener('input', function(e) {
      let value = e.target.value.replace(/\D/g, '');
      if (value.length <= 11) {
        value = value.replace(/(\d{2})(\d)/, '($1) $2');
        value = value.replace(/(\d{5})(\d)/, '$1-$2');
        e.target.value = value;
      }
    });
  </script>
</body>
</html> 