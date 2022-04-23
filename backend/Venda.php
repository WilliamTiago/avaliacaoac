<?php 

header("Content-Type: aplication/json");

require_once 'Conexao.php';

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

try{    
    $con = new Conexao();
    $con->setConexao();

    $acao = $_POST['acao'];

    switch ($acao){
    case 'create':
        //Cadastra um produto
        $venda = $_POST['venda'];
        if(empty($venda)){
            throw new Exception('As informações da venda não foram informadas!', 422);
        }
        $venda = json_decode($venda);
        if($venda->atualizar_valor_produto){
            $sql = "UPDATE avaliacao.produto SET valor_unitario = $venda->valor_unitario WHERE codigo = $venda->codigo_produto";
            $result = $con->query($sql, true);
            if(empty($result)){
                throw new Exception('Não foi possível atualizar o valor unitário do produto!', 500);
            }
        }
        $sql = "SELECT codigo FROM avaliacao.venda ORDER BY codigo DESC LIMIT 1";
        $con->query($sql);
        $result = $con->getArrayResults();
        $codigo = count($result[0]) === 0 ? 1 : $result[0]['codigo'] + 1;
        $data_venda = date('Y-m-d');
        $sql = "INSERT INTO avaliacao.venda (codigo, codigo_produto, quantidade, valor_unitario, data_venda) VALUES ($codigo, '$venda->codigo_produto', $venda->quantidade, $venda->valor_unitario, '$data_venda'x);";
        $result = $con->query($sql, true);
        if(empty($result)){
            throw new Exception('Não foi possível cadastrar a venda!', 500);
        }
        printResult($result);        
        break;
    case 'read':
        //Retorna lista com todos os produtos ativos
        $sql = 'SELECT  pro.codigo,
                        pro.descricao,
                        pro.valor_unitario
                FROM avaliacao.produto AS pro
                WHERE pro.ativo = 1;';
        $con->query($sql);
        $produtos = $con->getArrayResults();
        printResult($produtos);
        break;
    case 'update':
        
        break;
    case 'delete':
        
        break;
    case 'list':
        //Retorna lista com todos os produtos ativos
        $sql = 'SELECT  ven.codigo,
                        pro.descricao,
                        ven.quantidade,
                        ven.valor_unitario,
                        (SELECT (ven.quantidade * ven.valor_unitario) valor_total FROM avaliacao.venda) AS valor_total,
                        ven.data_venda
                FROM avaliacao.produto AS pro
                JOIN avaliacao.venda AS ven
                ON(pro.codigo = ven.codigo_produto)
                WHERE pro.ativo = 1;';
        $con->query($sql);
        $vendas = $con->getArrayResults();
        printResult($vendas);
        break;  
        
    case 'gettotal':
        //Retorna o total de produtos
        $sql = 'SELECT COUNT(codigo) AS total FROM avaliacao.venda;';
        $con->query($sql);
        $result = $con->getArrayResults();
        $total = (count($result) === 1) ? $result[0] : 0;
        print json_encode($total);
        break;
    default:
        throw new Exception('Nenhuma ação válida foi solicitada!');
    }
}catch(Exception $e){
    printResult(null, $e->getCode(), $e->getMessage());
}finally{
    $con->closeConexao();
    unset($con);
}

function printResult($result = null, $code = 200, $message = 'success'){
    $return = new stdClass();
    $return->code = $code;
    $return->message = $message;
    $return->result = $result;
    print json_encode($return);
}