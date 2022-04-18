<?php 

class Venda{
    
    private $codigo;
    private $codigo_produto;
    private $quantidade;
    private $valor_unitario;
    
    public function __construct($codigo, $codigo_produto, $quantidade, $valor_unitario) {
        $this->codigo         = $codigo;
        $this->codigo_produto = $codigo_produto;
        $this->quantidade     = $quantidade;
        $this->valor_unitario = $valor_unitario;
    }
        
    public function getCodigo() {
        return $this->codigo;
    }

    public function getCodigo_produto() {
        return $this->codigo_produto;
    }

    public function getQuantidade() {
        return $this->quantidade;
    }

    public function getValor_unitario() {
        return $this->valor_unitario;
    }

    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    public function setCodigo_produto($codigo_produto) {
        $this->codigo_produto = $codigo_produto;
    }

    public function setQuantidade($quantidade) {
        $this->quantidade = $quantidade;
    }

    public function setValor_unitario($valor_unitario) {
        $this->valor_unitario = $valor_unitario;
    }
    
}