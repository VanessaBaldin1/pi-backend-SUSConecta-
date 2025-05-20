<?php
require_once __DIR__ . '/src/services/MedicoService.php';

$medicoService = new MedicoService();
$mensagem = '';
$tipoMensagem = '';
$paginaAtual = 'medico';

// Buscar médico para edição
$medico = null;
if (isset($_GET['id'])) {
    $medico = $medicoService->getOne($_GET['id']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['acao'])) {
        switch ($_POST['acao']) {
            case 'criar':
                $dados = [
                    'nome' => $_POST['nome'],
                    'crm' => $_POST['crm'],
                    'especialidade' => $_POST['especialidade'],
                    'telefone' => $_POST['telefone'],
                    'email' => $_POST['email']
                ];
                if($medicoService->create($dados)) {
                    $mensagem = "Médico cadastrado com sucesso.";
                    $tipoMensagem = "success";
                } else {
                    $mensagem = "Erro ao cadastrar médico.";
                    $tipoMensagem = "error";
                }
                break;
            
            case 'atualizar':
                $dados = [
                    'id' => $_POST['id'],
                    'nome' => $_POST['nome'],
                    'crm' => $_POST['crm'],
                    'especialidade' => $_POST['especialidade'],
                    'telefone' => $_POST['telefone'],
                    'email' => $_POST['email']
                ];
                if($medicoService->update($dados)) {
                    $mensagem = "Médico atualizado com sucesso.";
                    $tipoMensagem = "success";
                } else {
                    $mensagem = "Erro ao atualizar médico.";
                    $tipoMensagem = "error";
                }
                break;
            
            case 'excluir':
                $resultado = $medicoService->delete($_POST['id']);
                $mensagem = $resultado['message'];
                $tipoMensagem = $resultado['status'];
                break;
        }
    }
}

$medicos = $medicoService->getAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Médicos - Conecta-Consulta</title>
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
            <li><a href="medico.php" class="active">Médico</a></li>
            <li><a href="paciente.php">Paciente</a></li>
        </ul>
    </nav>
    <main>
        <section class="container">
            <h2>Cadastro de Médicos</h2>
            
            <?php if ($mensagem): ?>
                <div class="mensagem <?php echo $tipoMensagem; ?>">
                    <?php echo $mensagem; ?>
                    <button class="fechar-mensagem">&times;</button>
                </div>
            <?php endif; ?>

            <div class="card">
                <form class="formulario" method="POST" id="formMedico">
                    <input type="hidden" name="acao" value="criar">
                    <input type="hidden" name="id" id="id" value="">
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="nome">Nome Completo:</label>
                            <input type="text" id="nome" name="nome" required value="<?php echo isset($medico) ? htmlspecialchars($medico['nome']) : ''; ?>">
                        </div>

                        <div class="form-group">
                            <label for="crm">CRM:</label>
                            <input type="text" id="crm" name="crm" required value="<?php echo isset($medico) ? htmlspecialchars($medico['crm']) : ''; ?>">
                        </div>

                        <div class="form-group">
                            <label for="especialidade">Especialidade:</label>
                            <select id="especialidade" name="especialidade" required>
                                <option value="">Selecione uma especialidade</option>
                                <?php
                                $especialidades = [
                                    "Acupuntura", "Alergia e Imunologia", "Anestesiologia", "Angiologia",
                                    "Cardiologia", "Cirurgia Cardiovascular", "Cirurgia Geral",
                                    "Cirurgia Pediátrica", "Cirurgia Plástica", "Clínica Médica",
                                    "Dermatologia", "Endocrinologia", "Gastroenterologia",
                                    "Genética Médica", "Geriatria", "Ginecologia e Obstetrícia",
                                    "Hematologia", "Homeopatia", "Infectologia", "Mastologia",
                                    "Medicina de Família", "Medicina do Trabalho", "Medicina Esportiva",
                                    "Medicina Física e Reabilitação", "Medicina Intensiva",
                                    "Medicina Legal", "Medicina Nuclear", "Medicina Preventiva",
                                    "Nefrologia", "Neurocirurgia", "Neurologia", "Nutrologia",
                                    "Oftalmologia", "Oncologia", "Ortopedia e Traumatologia",
                                    "Otorrinolaringologia", "Patologia", "Pediatria", "Pneumologia",
                                    "Psiquiatria", "Radiologia", "Radioterapia", "Reumatologia",
                                    "Urologia"
                                ];
                                foreach ($especialidades as $esp) {
                                    $selected = (isset($medico) && $medico['especialidade'] === $esp) ? 'selected' : '';
                                    echo "<option value=\"$esp\" $selected>$esp</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="telefone">Telefone:</label>
                            <input type="tel" id="telefone" name="telefone" required value="<?php echo isset($medico) ? htmlspecialchars($medico['telefone']) : ''; ?>">
                        </div>

                        <div class="form-group">
                            <label for="email">E-mail:</label>
                            <input type="email" id="email" name="email" value="<?php echo isset($medico) ? htmlspecialchars($medico['email']) : ''; ?>">
                        </div>
                    </div>

                    <div class="form-buttons">
                        <?php if (isset($medico)): ?>
                            <input type="hidden" name="acao" value="atualizar">
                            <input type="hidden" name="id" value="<?php echo $medico['id']; ?>">
                            <button type="submit" class="btn-primary">Atualizar Médico</button>
                            <button type="button" class="btn-secondary" onclick="MedicoManager.limparFormulario()">Cancelar</button>
                        <?php else: ?>
                            <input type="hidden" name="acao" value="criar">
                            <button type="submit" class="btn-primary">Cadastrar Médico</button>
                            <button type="button" class="btn-secondary" onclick="MedicoManager.limparFormulario()">Limpar</button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <div class="card">
                <h3>Médicos Cadastrados</h3>
                <div class="table-responsive">
                    <table class="tabela">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>CRM</th>
                                <th>Especialidade</th>
                                <th>Telefone</th>
                                <th>E-mail</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($medicos['records']) && !empty($medicos['records'])): ?>
                                <?php foreach ($medicos['records'] as $medico): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($medico['nome']); ?></td>
                                    <td><?php echo htmlspecialchars($medico['crm']); ?></td>
                                    <td><?php echo htmlspecialchars($medico['especialidade']); ?></td>
                                    <td><?php echo htmlspecialchars($medico['telefone']); ?></td>
                                    <td><?php echo htmlspecialchars($medico['email']); ?></td>
                                    <td class="acoes">
                                        <button class="btn-icon" onclick="MedicoManager.editarMedico(<?php echo htmlspecialchars(json_encode($medico)); ?>)" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn-icon btn-danger" onclick="MedicoManager.confirmarExclusao(<?php echo $medico['id']; ?>, '<?php echo htmlspecialchars($medico['nome']); ?>')" title="Excluir">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">Nenhum médico cadastrado.</td>
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
            <p>Tem certeza que deseja excluir o médico <span id="nomeMedicoExclusao"></span>?</p>
            <form method="POST" action="medico.php">
                <input type="hidden" name="acao" value="excluir">
                <input type="hidden" name="id" id="idExclusao">
                <div class="modal-buttons">
                    <button type="submit" class="btn-danger">Confirmar Exclusão</button>
                    <button type="button" class="btn-secondary" onclick="MedicoManager.fecharModal()">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <footer>
        <img src="imagens/logotipo.png" alt="Logo Conecta-Consulta">
        <p>&copy; <?php echo date('Y'); ?> Conecta-Consulta. Todos os direitos reservados.</p>
        <p>Suporte: suporte@conectaconsulta.com</p>
    </footer>

    <script src="js/medico.js"></script>
</body>
</html> 