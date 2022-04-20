<?php

header("Content-Type: aplication/json");

require_once 'Conexao.php';

class Produto{

    private $codigo;
    private $descricao;
    private $valor_unitario;
    private $estoque;
    private $data_ultima_venda;
    private $total_de_vendas;

    public function __construct($codigo, $descricao, $valor_unitario, $estoque, $data_ultima_venda, $total_de_vendas){
        $this->codigo            = $codigo;
        $this->descricao         = $descricao;
        $this->valor_unitario    = $valor_unitario;
        $this->estoque           = $estoque;
        $this->data_ultima_venda = $data_ultima_venda;
        $this->total_de_vendas   = $total_de_vendas;
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

    public function getData_ultima_venda() {
        return $this->data_ultima_venda;
    }

    public function getTotal_de_vendas() {
        return $this->total_de_vendas;
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

    public function setData_ultima_venda($data_ultima_venda) {
        $this->data_ultima_venda = $data_ultima_venda;
    }

    public function setTotal_de_vendas($total_de_vendas) {
        $this->total_de_vendas = $total_de_vendas;
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
        
    case 'gettotal':
        //Retorna o total de produtos
        $sql = 'SELECT COUNT(codigo) AS total FROM avaliacao.produto;';
        $con->query($sql);
        $result = $con->getArrayResults();
        $total = (count($result) === 1) ? $result[0] : 0;
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
