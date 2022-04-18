<?php

require_once 'Conexao.php';
require_once 'Produto.php';
require_once 'Produto_excluido.php';
require_once 'Venda.php';

//header("Content-Type: aplication/json");
$data = [];

$funcao = $_REQUEST["funcao"];


//die(json_encode($data));
