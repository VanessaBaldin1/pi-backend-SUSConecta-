<?php
require_once '../Models/Paciente.php';
require_once '../Models/Atendimento.php';
require_once '../Models/Exame.php';

class PacienteView {
    private $paciente;
    private $atendimentos;
    private $exames;

    public function __construct() {
        $this->paciente = new Paciente();
        $this->atendimentos = new Atendimento();
        $this->exames = new Exame();
    }

    public function render() {
        ?>
        <!DOCTYPE html>
        <html lang="pt-BR">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Prontuário do Paciente - SUSConecta</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        </head>
        <body>
            <div class="container mt-4">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="mb-4">Prontuário do Paciente</h2>
                        
                        <!-- Informações do Paciente -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4>Informações Pessoais</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Nome:</strong> <?php echo $this->paciente->getNome(); ?></p>
                                        <p><strong>Data de Nascimento:</strong> <?php echo $this->paciente->getDataNascimento(); ?></p>
                                        <p><strong>CPF:</strong> <?php echo $this->paciente->getCpf(); ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Endereço:</strong> <?php echo $this->paciente->getEndereco(); ?></p>
                                        <p><strong>Telefone:</strong> <?php echo $this->paciente->getTelefone(); ?></p>
                                        <p><strong>Email:</strong> <?php echo $this->paciente->getEmail(); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Últimas Consultas -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4>Últimas Consultas</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Data</th>
                                                <th>Especialidade</th>
                                                <th>Médico</th>
                                                <th>Diagnóstico</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $consultas = $this->atendimentos->getUltimasConsultas($this->paciente->getId());
                                            foreach ($consultas as $consulta) {
                                                echo "<tr>";
                                                echo "<td>" . date('d/m/Y H:i', strtotime($consulta['data_hora'])) . "</td>";
                                                echo "<td>" . $consulta['especialidades'] . "</td>";
                                                echo "<td>" . $consulta['nome_medico'] . "</td>";
                                                echo "<td>" . $consulta['diagnostico'] . "</td>";
                                                echo "<td>" . $consulta['status'] . "</td>";
                                                echo "</tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Exames Realizados -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4>Exames Realizados</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Data</th>
                                                <th>Tipo</th>
                                                <th>Laboratório</th>
                                                <th>Resultado</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $exames = $this->exames->getExamesPaciente($this->paciente->getId());
                                            foreach ($exames as $exame) {
                                                echo "<tr>";
                                                echo "<td>" . $exame['data'] . "</td>";
                                                echo "<td>" . $exame['tipo'] . "</td>";
                                                echo "<td>" . $exame['laboratorio'] . "</td>";
                                                echo "<td>" . $exame['resultado'] . "</td>";
                                                echo "<td>
                                                    <a href='exame.php?id=" . $exame['id_exame'] . "' class='btn btn-info btn-sm'>
                                                        <i class='fas fa-eye'></i> Ver Detalhes
                                                    </a>
                                                </td>";
                                                echo "</tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Observações Médicas -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4>Observações Médicas</h4>
                            </div>
                            <div class="card-body">
                                <div class="timeline">
                                    <?php
                                    $observacoes = $this->atendimentos->getObservacoesMedicas($this->paciente->getId());
                                    foreach ($observacoes as $obs) {
                                        echo "<div class='timeline-item mb-3'>";
                                        echo "<div class='timeline-date text-muted'>" . date('d/m/Y H:i', strtotime($obs['data_hora'])) . "</div>";
                                        echo "<div class='timeline-content'>";
                                        echo "<p><strong>Médico:</strong> " . $obs['nome_medico'] . "</p>";
                                        echo "<p><strong>Observação:</strong> " . $obs['observacoes'] . "</p>";
                                        echo "</div>";
                                        echo "</div>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        </body>
        </html>
        <?php
    }
}
?> 