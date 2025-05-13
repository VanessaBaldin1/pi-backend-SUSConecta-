<?php


?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Médico - Conecta-Consulta</title>
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
      <li><a href="medico.php" class="active">Médico</a></li>
      <li><a href="paciente.php">Paciente</a></li>
    </ul>
  </nav>
  <main>
    <section class="container">
      <h2>Cadastro de Médico</h2>
      <form class="formulario">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" placeholder="Nome completo" required>
        <label for="crm">CRM:</label>
        <input type="text" id="crm" name="crm" placeholder="CRM do médico" required>
        <label for="especialidade">Especialidade:</label>
        <select id="especialidade" name="especialidade" required>
          <option value="">Selecione uma especialidade</option>
          <option value="cardiologista">Cardiologista</option>
          <option value="clinico_geral">Clínico Geral</option>
          <option value="dermatologista">Dermatologista</option>
          <option value="geriatra">Geriatra</option>
          <option value="ortopedista">Ortopedista</option>
        </select>
        <label for="telefone">Telefone:</label>
        <input type="tel" id="telefone" name="telefone" placeholder="(99) 99999-9999">
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" placeholder="email@exemplo.com">
        <button type="submit">Salvar Médico</button>
      </form>
    </section>
  </main>
  <footer>
    <img src="imagens/logotipo.png" alt="Logo Conecta-Consulta">
    <p>&copy; 2025 Conecta-Consulta. Todos os direitos reservados.</p>
    <p>Suporte: suporte@conectaconsulta.com</p>
  </footer>
</body>
</html> 