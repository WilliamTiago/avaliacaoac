<?php

class Produto_excluido{
    
    private $codigo;
    private $descricao;
    private $valor_unitario;
    private $estoque;
    
    public function __construct($codigo, $descricao, $valor_unitario, $estoque) {
        $this->codigo = $codigo;
        $this->descricao = $descricao;
        $this->valor_unitario = $valor_unitario;
        $this->estoque = $estoque;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getValor_unitario() {
        return $this->valor_unitario;
    }

    public function getEstoque() {
        return $this->estoque;
    }

    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setValor_unitario($valor_unitario) {
        $this->valor_unitario = $valor_unitario;
    }

    public function setEstoque($estoque) {
        $this->estoque = $estoque;
    }

}