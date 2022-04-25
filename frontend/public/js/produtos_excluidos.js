//Requisição para listar os produtos desativados
listProdutosLixeira();

$(document).on("click", '.restoreProduto', function () {
    confirmRestoreProduto(this);
});

function renderRowProdutosLixeira(produto){
    let valor_unitario = formatMoney(produto.valor_unitario); 
    let row =   `<tr>
                    <td><span class="text-muted">${produto.codigo}</span></td>
                    <td>${produto.descricao}</td>
                    <td>${valor_unitario}</td>
                    <td>${produto.estoque}</td>
                    <td>
                        <a codigo="${produto.codigo}" class="icon restoreProduto" href="#">
                            <i class="fe fe-refresh-ccw"></i>
                        </a>					    
                    </td>   
                </tr>`;
    $('#listagem_produtos_lixeira').append(row);
}

function listProdutosLixeira(){
    $.post("../backend/Produto.php",
        {
            acao: "listrecyclebin",
        },
        function(data, status){
            if(status === 'success'){
                $.each(data.result, function( index, produto ) {
                    renderRowProdutosLixeira(produto);
                });
            }
        }
    );
}

function confirmRestoreProduto(record){
    let codigo = record.attributes['codigo'].value;
    let result = confirm('Tem certeza que deseja restaurar o produto de código ' + codigo);
    if(result){
        restoreProduto(codigo);
    }
}

function restoreProduto(codigo){
    $.post("../backend/Produto.php",
        {
            "acao": "restore",
            "codigo": codigo,
        },
        function(data, status){
            if((status === 'success') && (data.code === 200) && (data.result === true)){
                alert('Produto restaurado com sucesso!');
                location.reload();
            }
        }
    );
}


