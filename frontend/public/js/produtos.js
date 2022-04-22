listProdutos();

$(document).on("click", '.deleteProduto', function () {
    confirmDeleteProduto(this);
});

function renderRowProdutos(object){
    let valor_unitario = formatMoney(object.valor_unitario); 
    let data_ultima_venda = object.data_ultima_venda !== null ? formatDate(object.data_ultima_venda) : '--/--/--';
    let total_vendas = object.total_vendas !== null ? formatMoney(object.total_vendas) : 'R$0,00';
    let row =   `<tr>
                    <td><span class="text-muted">${object.codigo}</span></td>
                    <td>${object.descricao}</td>
                    <td>${valor_unitario}</td>
                    <td>${object.estoque}</td>
                    <td>${data_ultima_venda}</td>
                    <td>${total_vendas}</td>                         
                    <td>
                        <a class="icon" href="./form-produto-edit.html?codigo=${object.codigo}">
                            <i class="fe fe-edit"></i>
                        </a>			    
                    </td>
                    <td>
                        <a codigo="${object.codigo}" class="icon deleteProduto" href="javascript:void(0)">
                            <i class="fe fe-trash"></i>
                        </a>			    
                    </td>
                </tr>`;
    $('#listagem_produtos').append(row);
}

function listProdutos(){
    $.post("../backend/Produto.php",
        {
            acao: "list",
        },
        function(data, status){
            if(status === 'success'){
                $.each(data, function( index, object ) {
                    renderRowProdutos(object);
                });
            }
        }
    );
}

function confirmDeleteProduto(record){
    let codigo = record.attributes['codigo'].value;
    let result = confirm('Tem certeza que deseja excluir o produto de código ' + codigo);
    if(result){
        deleteProduto(codigo);
    }
}

function deleteProduto(codigo){
    $.post("../backend/Produto.php",
        {
            "acao": "delete",
            "codigo": codigo,
        },
        function(data, status){
            if((status === 'success') && (data === true)){
                alert('Produto excluído com sucesso!');
                location.reload();
            }
        }
    );
}


