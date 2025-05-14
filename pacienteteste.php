<?php
require_once __DIR__ . '/vendor/autoload.php';

use ConectaConsulta\Models\Paciente;

$paciente = new Paciente();
$mensagem = '';

// Processamento do formulário
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_POST['nome']) && !empty($_POST['data_nascimento']) && !empty($_POST['cpf'])) {
        $paciente->inserirPaciente(
            $_POST['nome'],
            $_POST['data_nascimento'],
            $_POST['cpf'],
            $_POST['endereco'],
            $_POST['telefone'],
            $_POST['email']
        );
        $mensagem = "Paciente cadastrado com sucesso!";
    } else {
        $mensagem = "Preencha todos os campos obrigatórios.";
    }
}

$pacientes = $paciente->listarTodos();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Paciente - Conecta-Consulta</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <nav>
    <div class="logo">
      <img src="imagens/logotipo.png" alt="Logo Conecta-Consulta">
      Conecta-Consulta
    </div>
    <ul>
      <li><a href="index.php">Início</a></li>
      <li><a href="atendimento.php">Atendimento</a></li>
      <li><a href="exame.php">Exame</a></li>
      <li><a href="medico.php">Médico</a></li>
      <li><a href="paciente.php" class="active">Paciente</a></li>
    </ul>
  </nav>

  <main>
    <section class="container">
      <h2>Cadastro de Paciente</h2>

      <?php if (!empty($mensagem)): ?>
        <p class="mensagem <?= strpos($mensagem, 'sucesso') !== false ? 'sucesso' : 'erro' ?>">
          <?= $mensagem ?>
        </p>
      <?php endif; ?>

      <form class="formulario" method="POST" action="paciente.php">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" placeholder="Nome completo" required>

        <label for="data_nascimento">Data de Nascimento:</label>
        <input type="date" id="data_nascimento" name="data_nascimento" required>

        <label for="cpf">CPF:</label>
        <input type="text" id="cpf" name="cpf" placeholder="000.000.000-00" required>

        <label for="endereco">Endereço:</label>
        <input type="text" id="endereco" name="endereco" placeholder="Endereço completo">

        <label for="telefone">Telefone:</label>
        <input type="tel" id="telefone" name="telefone" placeholder="(99) 99999-9999">

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" placeholder="email@exemplo.com">

        <button type="submit">Salvar Paciente</button>
      </form>
    </section>

    <?php if (!empty($pacientes)): ?>
    <section class="container">
      <h3>Pacientes Cadastrados</h3>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Data Nasc.</th>
            <th>CPF</th>
            <th>Endereço</th>
            <th>Telefone</th>
            <th>Email</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($pacientes as $p): ?>
          <tr>
            <td><?= htmlspecialchars($p['id']) ?></td>
            <td><?= htmlspecialchars($p['nome']) ?></td>
            <td><?= htmlspecialchars($p['data_nascimento']) ?></td>
            <td><?= htmlspecialchars($p['cpf']) ?></td>
            <td><?= htmlspecialchars($p['endereco']) ?></td>
            <td><?= htmlspecialchars($p['telefone']) ?></td>
            <td><?= htmlspecialchars($p['email']) ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </section>
    <?php endif; ?>
  </main>

  <footer>
    <img src="imagens/logotipo.png" alt="Logo Conecta-Consulta">
    <p>&copy; 2025 Conecta-Consulta. Todos os direitos reservados.</p>
    <p>Suporte: suporte@conectaconsulta.com</p>
  </footer>
</body>
</html>
