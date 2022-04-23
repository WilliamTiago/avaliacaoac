var codigo = null;

loadProduto();

$(document).on("click", '#editarProduto', function (event) {
    event.preventDefault();
    editProduto();
});

function loadProduto(){
    codigo = sessionStorage.getItem('codigo');
    if(!codigo){
        alert('O código do produto não foi recebido!');
        location.href = 'produtos.html';
    }
    $.post("../backend/Produto.php",
        {
            "acao": "read",
            "codigo": codigo,
        },
        function(data, status){
            if((status === 'success') && (data.code === 200) && (data.result !== null)){
                $('#descricao_produto').val(data.result.descricao);
                $('#estoque_produto').val(data.result.estoque);
                $('#codigo_barras_produto').val(data.result.codigo_barras);
                $('#valor_unitario_produto').val(data.result.valor_unitario);
            }else{
                alert(data.message);
                location.href = 'produtos.html';
            }
        }
    );
}

function editProduto(){
    let produto = {};
    produto.codigo = codigo;
    produto.descricao = $('#descricao_produto').val();
    produto.estoque = $('#estoque_produto').val();
    produto.codigo_barras = $('#codigo_barras_produto').val();
    produto.valor_unitario = $('#valor_unitario_produto').val();
    produto = JSON.stringify(produto);
    $.post("../backend/Produto.php",
        {
            "acao": "update",
            "produto":produto
        },
        function(data, status){
            if((status === 'success') && (data.code === 200) && (data.result === true)){
                alert('Produto atualizado com sucesso!');
                location.href = 'produtos.html';
            }else{
                alert(data.message);
            }
        }
    );
}