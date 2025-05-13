<?php

?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Exame - Conecta-Consulta</title>
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
      <li><a href="exame.php" class="active">Exame</a></li>
      <li><a href="medico.php">Médico</a></li>
      <li><a href="paciente.php">Paciente</a></li>
    </ul>
  </nav>
  <main>
    <section class="container">
      <h2>Registro de Exame</h2>
      <form class="formulario">
        <label for="paciente">Paciente:</label>
        <input type="text" id="paciente" name="paciente" placeholder="Nome do paciente" required>
        <label for="tipo">Tipo de Exame:</label>
        <input type="text" id="tipo" name="tipo" placeholder="Ex: Hemograma, Raio-X" required>
        <label for="data">Data do Exame:</label>
        <input type="date" id="data" name="data" required>
        <label for="resultado">Resultado:</label>
        <textarea id="resultado" name="resultado" rows="2" placeholder="Resultado do exame"></textarea>
        <button type="submit">Salvar Exame</button>
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