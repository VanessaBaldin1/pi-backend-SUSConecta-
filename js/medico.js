/**
 * Módulo de gerenciamento de médicos
 */
const MedicoManager = {
    /**
     * Preenche o formulário com os dados do médico para edição
     * @param {Object} medico - Dados do médico a ser editado
     */
    editarMedico: function(medico) {
        // Preenche o formulário com os dados do médico
        document.getElementById('id').value = medico.id;
        document.getElementById('nome').value = medico.nome;
        document.getElementById('crm').value = medico.crm;
        document.getElementById('especialidade').value = medico.especialidade;
        document.getElementById('telefone').value = medico.telefone;
        document.getElementById('email').value = medico.email;
        
        // Atualiza o formulário para modo de edição
        document.querySelector('input[name="acao"]').value = 'atualizar';
        document.querySelector('.btn-primary').textContent = 'Atualizar Médico';
        
        // Rola a página até o formulário
        document.querySelector('.formulario').scrollIntoView({ behavior: 'smooth' });
    },

    /**
     * Limpa o formulário e retorna ao modo de criação
     */
    limparFormulario: function() {
        document.getElementById('formMedico').reset();
        document.getElementById('id').value = '';
        document.querySelector('input[name="acao"]').value = 'criar';
        document.querySelector('.btn-primary').textContent = 'Cadastrar Médico';
    },

    /**
     * Abre o modal de confirmação de exclusão
     * @param {number} id - ID do médico
     * @param {string} nome - Nome do médico
     */
    confirmarExclusao: function(id, nome) {
        document.getElementById('idExclusao').value = id;
        document.getElementById('nomeMedicoExclusao').textContent = nome;
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
                MedicoManager.fecharModal();
            }
        }

        // Validação do formulário
        document.getElementById('formMedico').addEventListener('submit', function(event) {
            if (!MedicoManager.validarFormulario()) {
                event.preventDefault();
            }
        });

        // Máscara para o campo de telefone
        const telefoneInput = document.getElementById('telefone');
        if (telefoneInput) {
            telefoneInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length <= 11) {
                    value = value.replace(/^(\d{2})(\d)/g, '($1) $2');
                    value = value.replace(/(\d)(\d{4})$/, '$1-$2');
                    e.target.value = value;
                }
            });
        }
    },

    /**
     * Valida os campos do formulário
     * @returns {boolean} - true se o formulário é válido, false caso contrário
     */
    validarFormulario: function() {
        const campos = {
            nome: 'Nome',
            crm: 'CRM',
            especialidade: 'Especialidade',
            telefone: 'Telefone',
            email: 'E-mail'
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

        // Validação específica para CRM
        const crm = document.getElementById('crm').value.trim();
        if (crm && !/^\d{6,}$/.test(crm)) {
            mensagemErro += '- O CRM deve conter apenas números e ter pelo menos 6 dígitos\n';
            valido = false;
        }

        // Validação específica para e-mail
        const email = document.getElementById('email').value.trim();
        if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            mensagemErro += '- E-mail inválido\n';
            valido = false;
        }

        if (!valido) {
            alert('Por favor, corrija os seguintes erros:\n\n' + mensagemErro);
        }

        return valido;
    }
};

// Inicializa o módulo quando o documento estiver pronto
document.addEventListener('DOMContentLoaded', function() {
    MedicoManager.init();
}); 