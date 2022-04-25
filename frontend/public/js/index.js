//Requisição para obter o total de produtos ativos
getTotalProdutos();
//Requisição para obter o total de vendas
getTotalVendas();

function getTotalProdutos(){
    $.post("../backend/Produto.php",
        {
            acao: "gettotal",
        },
        function(data, status){
            if(status === 'success' && data.code === 200){
                $('#total_produtos').text(data.result.total);
            }
        }
    );
}

function getTotalVendas(){
    $.post("../backend/Venda.php",
        {
            acao: "gettotal",
        },
        function(data, status){
            if(status === 'success' && data.code === 200){
                $('#total_vendas').text(data.result.total);
            }
        }
    );
}





