var produtos = null;
var produto = null;

//Requisição para para carregar os dados do formulário de vends
loadFormVenda();
//Requisição para listar as vendas realizadas
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
    let index = this.selectedIndex - 1;
    produto = produtos[index];
    $('#valor_unitario_venda').val(produto.valor_unitario);
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
                    alert("No momento não existe nenhum produto disponível!;");
                }else{                    
                    $.each(data.result, function( index, produto ) {
                        let option = `<option value="${produto.codigo}">${produto.descricao}</option>`;
                        $('#produto_venda').append(option);
                    });
                    produtos = data.result;
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
                    alert("No momento não existe nenhuma venda realizada!;");
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
    venda.atualizar_valor_produto = $('#atualizar_valor_produto')[0].checked;
    if(!venda.codigo_produto){
        alert('Atenção, um produto deve ser informado!');
        return;
    }
    if(venda.quantidade.length === 0){
        alert('Atenção, a quantidade deve ser informada!');
        return;
    }
    venda.quantidade = parseInt(venda.quantidade);
    if(venda.quantidade > produto.estoque){
        alert(`Atenção, a quantidade não pode ser superior ao estoque de ${produto.estoque} do produto ${produto.descricao}!`);
        return;
    }
    if(venda.quantidade === 0){
        alert(`Atenção, para realizar uma venda a quantidade mínima deve ser de 1 unidade!`);
        return;
    }
    if(venda.valor_unitario.length === 0){
        alert('Atenção, o valor unitário deve ser informado!');
        return;
    }
    venda.valor_unitario = venda.valor_unitario.replace(',', '.');
    if(isNaN(venda.valor_unitario)){
        alert('O valor unitário informado não é um número válido!');
        return;
    }
    venda.valor_unitario = parseFloat(venda.valor_unitario).toFixed(2);
    if(venda.valor_unitario > 99999999.99){
        alert('Atenção, o valor unitário não pode ser superior a 99999999.99!');
        return;
    }
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