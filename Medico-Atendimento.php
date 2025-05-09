
        <!DOCTYPE html>
        <html lang="pt-BR">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Dados do Médico - SUSConecta</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        </head>
        <body>
            <div class="container mt-4">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="mb-4">Dados do Médico</h2>
                        
                        <!-- Informações do Médico -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4>Informações Pessoais</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Nome:</strong> <?php echo $this->medico->getNome(); ?></p>
                                        <p><strong>CRM:</strong> <?php echo $this->medico->getCrm(); ?></p>
                                        <p><strong>Especialidade:</strong> <?php echo $this->medico->getEspecialidade(); ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Telefone:</strong> <?php echo $this->medico->getTelefone(); ?></p>
                                        <p><strong>Email:</strong> <?php echo $this->medico->getEmail(); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Atendimentos do Dia -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4>Atendimentos do Dia</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Horário</th>
                                                <th>Paciente</th>
                                                <th>Status</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $atendimentos = $this->atendimentos->getAtendimentosDoDia($this->medico->getId());
                                            foreach ($atendimentos as $atendimento) {
                                                echo "<tr>";
                                                echo "<td>" . date('H:i', strtotime($atendimento['data_hora'])) . "</td>";
                                                echo "<td>" . $atendimento['nome_paciente'] . "</td>";
                                                echo "<td>" . $atendimento['status'] . "</td>";
                                                echo "<td>
                                                    <a href='atendimento.php?id=" . $atendimento['id'] . "' class='btn btn-primary btn-sm'>
                                                        <i class='fas fa-edit'></i> Atender
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
                    </div>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        </body>
        </html>
        