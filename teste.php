<!-- Formulário para Cadastro de Médico -->
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">Cadastro de Médico</h2>
            <form action="processa_medico.php" method="POST">
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome do Médico</label>
                    <input type="text" class="form-control" id="nome" name="nome" required>
                </div>
                <div class="mb-3">
                    <label for="endereco" class="form-label">Endereço</label>
                    <input type="text" class="form-control" id="endereco" name="endereco" required>
                </div>
                <div class="mb-3">
                    <label for="telefone" class="form-label">Telefone</label>
                    <input type="text" class="form-control" id="telefone" name="telefone" required>
                </div>
                <div class="mb-3">
                    <label for="crm" class="form-label">CRM</label>
                    <input type="text" class="form-control" id="crm" name="crm" required>
                </div>
                <div class="mb-3">
                    <label for="especialidade" class="form-label">Especialidade</label>
                    <input type="text" class="form-control" id="especialidade" name="especialidade" required>
                </div>
                <button type="submit" class="btn btn-primary">Cadastrar</button>
            </form>
 