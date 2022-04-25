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
    produto.valor_unitario = $('#valor_unitario_produto').val();
    if(produto.descricao.length < 3){
        alert('Atenção, a descrição do produto deve conter no mínimo 3 caracteres!');
        return;
    }
    if(produto.descricao.length > 50){
        alert('Atenção, a descrição do produto deve conter no máximo 50 caracteres!');
        return;
    }
    if(produto.estoque.length === 0){
        alert('Atenção, o estoque deve ser informdo!');
        return;
    }
    produto.estoque = parseInt(produto.estoque);
    if(produto.estoque > 2147483647){
        alert('Atenção, o estoque não pode ser superior a 2147483647');
        return;
    }
    if(produto.codigo_barras.length < 3){
        alert('Atenção, o código de barras deve conter no mínimo 3 caracteres!');
        return;
    }
    if(produto.codigo_barras.length > 30){
        alert('Atenção, o código de barras deve conter no máximo 30 caracteres!');
        return;
    }
    if(produto.valor_unitario.length === 0){
        alert('Atenção, o valor unitário deve ser informado!');
        return;
    }
    produto.valor_unitario = produto.valor_unitario.replace(',', '.');
    if(isNaN(produto.valor_unitario)){
        alert('O valor unitário informado não é um número válido!');
        return;
    }
    produto.valor_unitario = parseFloat(produto.valor_unitario).toFixed(2);
    if(produto.valor_unitario > 99999999.99){
        alert('Atenção, o valor unitário não pode ser superior a 99999999.99!');
        return;
    }
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