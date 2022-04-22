//$('#valor_unitario_produto').mask('000.000.000,00', {reverse: true});

$(document).on("click", '#cadastrarProduto', function () {
    cadastraProduto();
});

function cadastraProduto(){
    let produto = {};
    produto.descricao_produto = $('#descricao_produto').val();
    produto.estoque_produto = $('#estoque_produto').val();
    produto.codigo_barras_produto = $('#codigo_barras_produto').val();
    produto.valor_unitario_produto = $('#valor_unitario_produto').val();
    produto = JSON.stringify(produto);
    $.post("../backend/Produto.php",
    {
        acao: "create",
        "produto":produto
    },
    function(data, status){
        if(status === 'success'){
            alert('Novo produto cadastrado com sucesso!');
            location.href('avaliacaoac/frontend/produtos.html');
        }
    }
);
}