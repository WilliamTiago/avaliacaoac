<?php

header("Content-Type: aplication/json");

require_once 'Conexao.php';

class Produto{

    private $codigo;
    private $descricao;
    private $valor_unitario;
    private $estoque;
    private $ativo;

    public function __construct($codigo, $descricao, $valor_unitario, $estoque, $ativo){
        $this->codigo            = $codigo;
        $this->descricao         = $descricao;
        $this->valor_unitario    = $valor_unitario;
        $this->estoque           = $estoque;
        $this->ativo             = $ativo;
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

    public function getAtivo() {
        return $this->ativo;
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

    public function setAtivo($ativo) {
        $this->ativo = $ativo;
    }
    
}

try{    
    $con = new Conexao();
    $con->setConexao();

    $acao = $_POST['acao'];

    switch ($acao){
    case 'create':
        
        break;
    case 'read':
        
        break;
    case 'update':
        
        break;
    case 'delete':
        
        break;
    case 'list':
        //Retorna lista com todos os produtos
        $sql = 'SELECT  pro.codigo,
                        pro.descricao,
                        pro.valor_unitario,
                        pro.estoque,
                        pro.ativo,
                        (SELECT data_venda FROM avaliacao.venda WHERE venda.codigo_produto = pro.codigo) AS data_ultima_venda,
                        (SELECT (venda.quantidade * valor_unitario) FROM avaliacao.venda WHERE venda.codigo_produto = pro.codigo) AS total_vendas
                FROM avaliacao.produto AS pro;';
        $con->query($sql);
        $produtos = $con->getArrayResults();
        print json_encode($produtos);
        break;        
    case 'gettotal':
        //Retorna o total de produtos
        $sql = 'SELECT COUNT(codigo) AS total FROM avaliacao.produto;';
        $con->query($sql);
        $total = $con->getArrayResults();
        print json_encode($total);
        break;
    default:
        throw new Exception('Nenhuma ação válida foi solicitada!');
    }
}catch(Exception $e){
    print('Code:' . $e->getCode() . ' Message:' . $e->getMessage());
}finally{
    $con->closeConexao();
    unset($con);
}
