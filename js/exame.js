/**
 * Módulo de gerenciamento de exames
 */
const ExameManager = {
    /**
     * Preenche o formulário com os dados do exame para edição
     * @param {Object} exame - Dados do exame a ser editado
     */
    editarExame: function(exame) {
        // Preenche o formulário com os dados do exame
        document.getElementById('id').value = exame.id;
        document.getElementById('paciente_id').value = exame.nome_paciente;
        document.getElementById('medico_id').value = exame.nome_medico;
        document.getElementById('tipo_exame').value = exame.tipo_exame;
        document.getElementById('data_exame').value = exame.data_exame;
        document.getElementById('hora_exame').value = exame.hora_exame;
        document.getElementById('status').value = exame.status;
        document.getElementById('resultado').value = exame.resultado;
        
        // Atualiza o formulário para modo de edição
        document.querySelector('input[name="acao"]').value = 'atualizar';
        document.querySelector('.btn-primary').textContent = 'Atualizar Exame';
        
        // Rola a página até o formulário
        document.querySelector('.formulario').scrollIntoView({ behavior: 'smooth' });
    },

    /**
     * Limpa o formulário e retorna ao modo de criação
     */
    limparFormulario: function() {
        document.getElementById('formExame').reset();
        document.getElementById('id').value = '';
        document.querySelector('input[name="acao"]').value = 'criar';
        document.querySelector('.btn-primary').textContent = 'Agendar Exame';
    },

    /**
     * Abre o modal de confirmação de exclusão
     * @param {number} id - ID do exame
     * @param {string} nome - Nome do paciente
     */
    confirmarExclusao: function(id, nome) {
        document.getElementById('idExclusao').value = id;
        document.getElementById('nomePacienteExclusao').textContent = nome;
        document.getElementById('modalExclusao').style.display = 'flex';
    },

    /**
     * Fecha o modal de exclusão
     */
    fecharModal: function() {
        document.getElementById('modalExclusao').style.display = 'none';
    },

    /**
     * Inicializa os event listeners
     */
    init: function() {
        // Fecha mensagens de alerta ao clicar no X
        document.querySelectorAll('.fechar-mensagem').forEach(button => {
            button.addEventListener('click', function() {
                this.parentElement.style.display = 'none';
            });
        });

        // Fecha modal ao clicar fora dele
        window.onclick = function(event) {
            if (event.target == document.getElementById('modalExclusao')) {
                ExameManager.fecharModal();
            }
        }

        // Validação do formulário
        document.getElementById('formExame').addEventListener('submit', function(event) {
            if (!ExameManager.validarFormulario()) {
                event.preventDefault();
            }
        });
    },

    /**
     * Valida os campos do formulário
     * @returns {boolean} - true se o formulário é válido, false caso contrário
     */
    validarFormulario: function() {
        const campos = {
            paciente_id: 'Paciente',
            medico_id: 'Médico',
            tipo_exame: 'Tipo de Exame',
            data_exame: 'Data do Exame',
            hora_exame: 'Hora do Exame',
            status: 'Status'
        };

        let valido = true;
        let mensagemErro = '';

        for (const [id, label] of Object.entries(campos)) {
            const campo = document.getElementById(id);
            if (!campo.value.trim()) {
                mensagemErro += `- O campo ${label} é obrigatório\n`;
                valido = false;
            }
        }

        if (!valido) {
            alert('Por favor, corrija os seguintes erros:\n\n' + mensagemErro);
        }

        return valido;
    }
};

// Inicializa o módulo quando o documento estiver pronto
document.addEventListener('DOMContentLoaded', function() {
    ExameManager.init();
}); 