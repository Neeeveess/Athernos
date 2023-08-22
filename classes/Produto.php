<?php
    class Produtos extends Crud{
        private $codigo;
        private $nome;
        private $quantidade;
        private $custo;
        private $validade;

        public function getCodigo(){
            return $this->codigo;
        }

        public function setCodigo($valor){
            $this->codigo = $valor;
        }

        public function getQuantidade(){
            return $this->quantidade;
        }

        public function setQuantidade($valor){
            $this->quantidade = $valor;
        }

        public function getCusto(){
            return $this->custo;
        }

        public function setCusto($valor){
            $this->custo = $valor;
        }

        public function getValidade(){
            return $this->codigo;
        }

        public function setValidade($valor){
            $this->validade = $valor;
        }

        
    }

?>