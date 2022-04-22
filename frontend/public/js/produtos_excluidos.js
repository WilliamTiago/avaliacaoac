listProdutosLixeira();

$(document).on("click", '.restoreProduto', function () {
    confirmRestoreProduto(this);
});

function renderRowProdutosLixeira(object){
    let valor_unitario = formatMoney(object.valor_unitario); 
    let row =   `<tr>
                    <td><span class="text-muted">${object.codigo}</span></td>
                    <td>${object.descricao}</td>
                    <td>${valor_unitario}</td>
                    <td>${object.estoque}</td>
                    <td>
                        <a codigo="${object.codigo}" class="icon restoreProduto" href="#">
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
                $.each(data, function( index, object ) {
                    renderRowProdutosLixeira(object);
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
            if((status === 'success') && (data === true)){
                alert('Produto restaurado com sucesso!');
                location.reload();
            }
        }
    );
}


