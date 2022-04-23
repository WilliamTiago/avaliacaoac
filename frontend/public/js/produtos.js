listProdutos();

$(document).on("click", '.deleteProduto', function () {
    confirmDeleteProduto(this);
});

function renderRowProdutos(produto){
    let valor_unitario = formatMoney(produto.valor_unitario); 
    let data_ultima_venda = produto.data_ultima_venda !== null ? formatDate(produto.data_ultima_venda) : '--/--/--';
    let total_vendas = produto.total_vendas !== null ? formatMoney(produto.total_vendas) : 'R$0,00';
    let row =   `<tr>
                    <td><span class="text-muted">${produto.codigo}</span></td>
                    <td>${produto.descricao}</td>
                    <td>${valor_unitario}</td>
                    <td>${produto.estoque}</td>
                    <td>${data_ultima_venda}</td>
                    <td>${total_vendas}</td>                         
                    <td>
                        <a onclick="loadFormEditProduto(${produto.codigo})" class="icon" href="./form-produto-edit.html">
                            <i class="fe fe-edit"></i>
                        </a>			    
                    </td>
                    <td>
                        <a codigo="${produto.codigo}" class="icon deleteProduto" href="javascript:void(0)">
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
            if((status === 'success') && (data.code === 200)){
                $.each(data.result, function( index, produto ) {
                    renderRowProdutos(produto);
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
            if((status === 'success') && (data.code === 200) && (data.result === true)){
                alert('Produto excluído com sucesso!');
                location.reload();
            }
        }
    );
}

function loadFormEditProduto(codigo){
    sessionStorage.setItem("codigo",codigo);
    location.href = 'form-produto-edit.html';
}

