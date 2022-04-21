function renderRowProdutos(object){
    let valor_unitario = formatMoney(object.valor_unitario); 
    let data_ultima_venda = object.data_ultima_venda !== null ? object.data_ultima_venda : '--/--/--';
    let total_vendas = object.total_vendas !== null ? object.total_vendas : '0,00';
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
                        <a class="icon" href="javascript:void(0)">
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

listProdutos();