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
        //Cadastra um produto
        $produto = $_POST['produto'];
        if(empty($produto)){
            throw new Exception('As informações do produto não foram recebidas!', 422);
        }

        break;
    case 'read':
        //Busca as informações de um produto
        
        break;
    case 'update':
        //Atualiza um produto
        break;
    case 'delete':
        //Desativa produto
        $codigo = $_POST['codigo'];
        $sql = "UPDATE avaliacao.produto SET ativo = 0 WHERE codigo = $codigo";
        $result = $con->query($sql, true);
        print json_encode($result);
        break;
    case 'restore':
        //Restaura produto
        $codigo = $_POST['codigo'];
        $sql = "UPDATE avaliacao.produto SET ativo = 1 WHERE codigo = $codigo";
        $result = $con->query($sql, true);
        print json_encode($result);
        break;
    case 'list':
        //Retorna lista com todos os produtos ativos
        $sql = 'SELECT  pro.codigo,
                        pro.descricao,
                        pro.valor_unitario,
                        pro.estoque,
                        (SELECT data_venda FROM avaliacao.venda WHERE venda.codigo_produto = pro.codigo ORDER BY venda.data_venda DESC LIMIT 1) AS data_ultima_venda,
                        (SELECT SUM(venda.quantidade * valor_unitario) FROM avaliacao.venda WHERE venda.codigo_produto = pro.codigo) AS total_vendas
                FROM avaliacao.produto AS pro
                WHERE pro.ativo = 1;';
        $con->query($sql);
        $produtos = $con->getArrayResults();
        print json_encode($produtos);
        break;  
    case 'listrecyclebin':
        //Retorna lista com todos os produtos ativos      
        $sql = 'SELECT  pro.codigo,
                        pro.descricao,
                        pro.valor_unitario,
                        pro.estoque
                        FROM avaliacao.produto AS pro
                WHERE pro.ativo = 0;';
        $con->query($sql);
        $produtos = $con->getArrayResults();
        print json_encode($produtos);
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

