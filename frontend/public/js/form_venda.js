loadFormVenda();
listVendas();

$(document).on("click", '#cadastrarVenda', function (event) {
    event.preventDefault();
    cadastraVenda();
});

$(document).on("change", '#quantidade_venda', function (event) {
    updateValorTotal();
});

$(document).on("change", '#valor_unitario_venda', function (event) {
    updateValorTotal();
});

$(document).on("change", '#produto_venda', function () {
    let valor_unitario = this.selectedOptions[0].attributes['valor_unitario'].value;
    $('#valor_unitario_venda').val(valor_unitario);
    updateValorTotal();
});

function updateValorTotal(){
    let quantidade = $('#quantidade_venda').val();
    let valor_unitario = $('#valor_unitario_venda').val();
    let valor_total = quantidade * valor_unitario;
    $('#valor_total_venda').val(valor_total);
}

function loadFormVenda(){
    $.post("../backend/Venda.php",
        {
            acao: "read",
        },
        function(data, status){
            if((status === 'success') && (data.code === 200)){
                if(data.result.length === 0){
                    alert("No momento não existe nenhum produto cadastrado!;");
                }else{                    
                    $.each(data.result, function( index, produto ) {
                        let option = `<option valor_unitario="${produto.valor_unitario}" value="${produto.codigo}">${produto.descricao}</option>`;
                        $('#produto_venda').append(option);
                    });
                    $('#produto_venda').val(0);
                }
            }
        }
    );
}

function renderRowVendas(venda){
    let valor_unitario = formatMoney(venda.valor_unitario); 
    let valor_total = formatMoney(venda.valor_total);
    let data_venda = formatDate(venda.data_venda);
    let row =   `<tr>
                    <td><span class="text-muted">${venda.codigo}</span></td>
                    <td>${venda.descricao}</td>
                    <td>${venda.quantidade}</td>
                    <td>${valor_unitario}</td>
                    <td>${valor_total}</td>      
                    <td>${data_venda}</td>                  
                </tr>`;
    $('#listagem_vendas').append(row);
}

function listVendas(){
    $.post("../backend/Venda.php",
        {
            acao: "list",
        },
        function(data, status){
            if((status === 'success') && (data.code === 200)){
                if(data.result.length === 0){
                    alert("No momento não existe nenhuma venda realizada;");
                }else{
                    $.each(data.result, function( index, venda ) {
                        renderRowVendas(venda);
                    });
                }
            }
        }
    );
}

function cadastraVenda(){
    let venda = {};
    venda.codigo_produto = $('#produto_venda').val();
    venda.quantidade = $('#quantidade_venda').val();
    venda.valor_unitario = $('#valor_unitario_venda').val();
    venda.valor_total = $('#valor_total_venda').val();
    venda.atualizar_valor_produto = $('#atualizar_valor_produto').val() ? $('#atualizar_valor_produto').val() : false;
    venda = JSON.stringify(venda);
    $.post("../backend/Venda.php",
        {
            "acao": "create",
            "venda":venda
        },
        function(data, status){
            if((status === 'success') && (data.code === 200) && (data.result === true)){
                alert('Nova venda cadastrada com sucesso!');
                location.href = 'form-venda.html';
            }else{
                alert(data.message);
            }
        }
    );
}