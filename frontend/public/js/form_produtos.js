//$('#valor_unitario_produto').mask('000.000.000,00', {reverse: true});

$(document).on("click", '#cadastrarProduto', function (event) {
    event.preventDefault();
    cadastraProduto();
});

function cadastraProduto(){
    let produto = {};
    produto.descricao = $('#descricao_produto').val();
    produto.estoque = $('#estoque_produto').val();
    produto.codigo_barras = $('#codigo_barras_produto').val();
    produto.valor_unitario = $('#valor_unitario_produto').val();
    produto = JSON.stringify(produto);
    $.post("../backend/Produto.php",
        {
            "acao": "create",
            "produto":produto
        },
        function(data, status){
            if((status === 'success') && (data.code === 200) && (data.result === true)){
                alert('Novo produto cadastrado com sucesso!');
                location.href = 'produtos.html';
            }
        }
    );
}