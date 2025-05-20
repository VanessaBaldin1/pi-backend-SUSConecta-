<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <nav>
        <div class="logo">
            <img src="imagens/logotipo.png" alt="Logo <?php echo APP_NAME; ?>">
            <?php echo APP_NAME; ?>
        </div>
        <ul>
            <li><a href="index.php" <?php echo $paginaAtual === 'inicio' ? 'class="active"' : ''; ?>>Início</a></li>
            <li><a href="consulta.php" <?php echo $paginaAtual === 'consulta' ? 'class="active"' : ''; ?>>Consulta</a></li>
            <li><a href="exame.php" <?php echo $paginaAtual === 'exame' ? 'class="active"' : ''; ?>>Exame</a></li>
            <li><a href="medico.php" <?php echo $paginaAtual === 'medico' ? 'class="active"' : ''; ?>>Médico</a></li>
            <li><a href="paciente.php" <?php echo $paginaAtual === 'paciente' ? 'class="active"' : ''; ?>>Paciente</a></li>
        </ul>
    </nav>
    <main>
        <section class="container"> 