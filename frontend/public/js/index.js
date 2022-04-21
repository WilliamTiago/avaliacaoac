//Requisição para obter o total de produtos
getTotalProdutos();
//Requisição para obter o total de vendas
getTotalVendas();

function getTotalProdutos(){
    $.post("../backend/Produto.php",
        {
            acao: "gettotal",
        },
        function(data, status){
            if(status === 'success'){
                $('#total_produtos').text(data.total);
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
            if(status === 'success'){
                $('#total_vendas').text(data.total);
            }
        }
    );
}





