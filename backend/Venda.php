<?php 

header("Content-Type: aplication/json");

require_once 'Conexao.php';

try{    
    $con = new Conexao();
    $con->setConexao();

    $acao = $_POST['acao'];

    switch ($acao){
    case 'create':
        //Cadastra uma venda
        $venda = $_POST['venda'];
        if(empty($venda)){
            throw new Exception('As informações da venda não foram informadas!', 422);
        }
        $venda = json_decode($venda);
        //Verifica se a quantidade a ser vendida não é superior ao estoque atual do produto
        $sql = "SELECT estoque FROM avaliacao.produto AS pro WHERE pro.codigo = $venda->codigo_produto";
        $con->query($sql);
        $estoque = (int) $con->getArrayResults()[0]['estoque'];
        if($venda->quantidade > $estoque){
            throw new Exception('A quantidade de venda informada é superior ao estoque disponível do produto!', 500);
        }
        //Verifica se precisa atualizar valor unitário do produto e o atualiza caso for necessário
        if($venda->atualizar_valor_produto){
            $sql = "UPDATE avaliacao.produto SET valor_unitario = $venda->valor_unitario WHERE codigo = $venda->codigo_produto";
            $result = $con->query($sql, true);
            if(empty($result)){
                throw new Exception('Não foi possível atualizar o valor unitário do produto!', 500);
            }
        }
        //Cadastra a venda
        $sql = "SELECT codigo FROM avaliacao.venda ORDER BY codigo DESC LIMIT 1";
        $con->query($sql);
        $result = $con->getArrayResults();
        $codigo = count($result[0]) === 0 ? 1 : $result[0]['codigo'] + 1;
        $data_venda = date('Y-m-d');
        $sql = "INSERT INTO avaliacao.venda (codigo, codigo_produto, quantidade, valor_unitario, data_venda) VALUES ($codigo, '$venda->codigo_produto', $venda->quantidade, $venda->valor_unitario, '$data_venda');";
        $result = $con->query($sql, true);
        if(empty($result)){
            throw new Exception('Não foi possível cadastrar a venda!', 500);
        }
        //Atualiza o estoque do produto
        $estoque = $estoque - $venda->quantidade;
        $sql = "UPDATE avaliacao.produto SET estoque = $estoque WHERE codigo = $venda->codigo_produto";
        $result = $con->query($sql, true);
        if(empty($result)){
            throw new Exception('Não foi possível atualizar o estoque do produto!', 500);
        }
        printResult($result);        
        break;
    case 'read':
        //Retorna lista com todos os produtos ativos para o cadastro de vendas
        $sql = 'SELECT  pro.codigo,
                        pro.descricao,
                        pro.valor_unitario,
                        pro.estoque
                FROM avaliacao.produto AS pro
                WHERE pro.ativo = 1;';
        $con->query($sql);
        $produtos = $con->getArrayResults();
        printResult($produtos);
        break;
    case 'list':
        //Retorna lista com todas as vendas
        $sql = 'SELECT  ven.codigo,
                        pro.descricao,
                        ven.quantidade,
                        ven.valor_unitario,
                        (ven.quantidade * ven.valor_unitario) valor_total,
                        ven.data_venda
                FROM avaliacao.produto AS pro
                JOIN avaliacao.venda AS ven
                ON(pro.codigo = ven.codigo_produto)
                ORDER BY ven.codigo DESC';
        $con->query($sql);
        $vendas = $con->getArrayResults();
        printResult($vendas);
        break;  
    case 'gettotal':
        //Retorna o total de vendas
        $sql = 'SELECT COUNT(codigo) AS total FROM avaliacao.venda;';
        $con->query($sql);
        $result = $con->getArrayResults();
        $total = (count($result) === 1) ? $result[0] : 0;
        printResult($total);
        break;
    default:
        throw new Exception('Nenhuma ação válida foi solicitada!');
    }
}catch(Exception $e){
    printResult(null, $e->getCode(), $e->getMessage());
}catch(Error $e){
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