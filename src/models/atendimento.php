<?php 
namespace ConectaConsulta\models;

final class Atendimento {
    private ?int $id;
    private string $nome;
    private string $dataHora;
    private string $diagnostico;
    private string $prescricao;

    public function __construct(string $nome,string $dataHora,string $diagnostico, string $prescricao, ?int $id = null)
    {
       $this->setNome($nome);
       $this->setId($id);
       $this->setDataHora($dataHora);
       $this->setDiagnostico($diagnostico);
       $this->setPrescricao($prescricao); 
    }

    public function getNome():string {
        return $this->nome;
    }

    public function getDataHora():string {
        return $this->dataHora;
    }

    public function getDiagnostico():string {
        return $this->diagnostico;
    }

    public function getPrescricao():string {
        return $this->prescricao;
    }

    public function getId(): ?int {
        return $this->id;
    }

    private function setNome(string $nome):void {
        $this->nome = $nome;
    }

    private function setDataHora(string $dataHora):void {
        $this->dataHora = $dataHora;
    }

    private function setDiagnostico(string $diagnostico):void {
        $this->diagnostico = $diagnostico;
    }

    private function setPrescricao(string $prescricao):void {
        $this->prescricao = $prescricao;
    }

    private function setId(?int $id):void {
        $this->id = $id;
    }








    
    
}

