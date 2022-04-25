<?php

header("Content-Type: aplication/json");

require_once 'Conexao.php';

try{    
    $con = new Conexao();
    $con->setConexao();

    $acao = $_POST['acao'];

    switch ($acao){
    case 'create':
        //Cadastra um produto
        $produto = $_POST['produto'];
        if(empty($produto)){
            throw new Exception('As informações do produto não foram informadas!', 422);
        }
        $produto = json_decode($produto);
        $sql = "SELECT codigo FROM avaliacao.produto ORDER BY codigo DESC LIMIT 1";
        $con->query($sql);
        $result = $con->getArrayResults();
        $codigo = count($result[0]) === 0 ? 1 : $result[0]['codigo'] + 1;
        $sql = "INSERT INTO avaliacao.produto (codigo, descricao, valor_unitario, codigo_barras, estoque) VALUES ($codigo, '$produto->descricao', $produto->valor_unitario, $produto->codigo_barras, $produto->estoque);";
        $result = $con->query($sql, true);
        if(empty($result)){
            throw new Exception('Não foi possível cadastrar o produto!',500);
        };
        printResult($result);
        break;
    case 'read':
        //Busca as informações de um produto
        $codigo = $_POST['codigo'];
        if(empty($codigo)){
            throw new Exception('O código do produto não foi informado!', 422);
        }
        $sql = "SELECT descricao, estoque, codigo_barras, valor_unitario FROM avaliacao.produto WHERE codigo = $codigo LIMIT 1";
        $con->query($sql);
        $result = $con->getArrayResults();
        if(count($result[0]) === 0){
            throw new Exception("O produto com o código $codigo não foi encontrado!", 422);
        }
        printResult($result[0]);
        break;
    case 'update':
        //Atualiza um produto
        $produto = $_POST['produto'];
        if(empty($produto)){
            throw new Exception('As informações do produto não foram informadas!', 422);
        }
        $produto = json_decode($produto);
        $sql = "UPDATE avaliacao.produto SET descricao = '$produto->descricao', estoque = $produto->estoque, codigo_barras = $produto->codigo_barras, valor_unitario = $produto->valor_unitario WHERE codigo = $produto->codigo";
        $result = $con->query($sql, true);
        if(empty($result)){
            throw new Exception('Não foi possível alterar o produto!', 500);
        }
        printResult($result);
        break;
    case 'delete':
        //Desativa produto
        $codigo = $_POST['codigo'];
        if(empty($codigo)){
            throw new Exception('O código do produto não foi informado!', 422);
        }
        $sql = "UPDATE avaliacao.produto SET ativo = 0 WHERE codigo = $codigo";
        $result = $con->query($sql, true);
        printResult($result);
        break;
    case 'restore':
        //Restaura produto
        $codigo = $_POST['codigo'];
        if(empty($codigo)){
            throw new Exception('O código do produto não foi informado!', 422);
        }
        $sql = "UPDATE avaliacao.produto SET ativo = 1 WHERE codigo = $codigo";
        $result = $con->query($sql, true);
        printResult($result);
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
        printResult($produtos);
        break;  
    case 'listrecyclebin':
        //Retorna lista com todos os produtos desativados      
        $sql = 'SELECT  pro.codigo,
                        pro.descricao,
                        pro.valor_unitario,
                        pro.estoque
                        FROM avaliacao.produto AS pro
                WHERE pro.ativo = 0;';
        $con->query($sql);
        $produtos = $con->getArrayResults();
        printResult($produtos);
        break; 
    case 'gettotal':
        //Retorna o total de produtos ativos
        $sql = 'SELECT COUNT(codigo) AS total FROM avaliacao.produto WHERE produto.ativo = 1;';
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