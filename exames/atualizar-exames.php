<?php 
require_once "../Paciente-Atendimento.php";

require_once "../Medico-Atendimento.php";

$listarUsuarios = $listarUsuarios($conexao);

if(isset($_POST['atualizar'])){
    $nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_SPECIAL_CHARS);
    $dataNascimento = filter_input(INPUT_POST, "nascimento",FILTER_SANITIZE_STRING);
    $cpf = filter_input(INPUT_POST, "cpf", FILTER_SANITIZE_NUMBER_FLOAT);
    $endereco = filter_input(INPUT_POST, "endereco",FILTER_SANITIZE_SPECIAL_CHARS);
    $telefone = filter_input(INPUT_POST, "telefone", FILTER_SANITIZE_NUMBER_FLOAT );
    $email = filter_input(INPUT_POST, "email", )
}
