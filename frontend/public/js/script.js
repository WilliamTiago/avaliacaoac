//Requisição para obter o total de produtos
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

//Requisição para obter o total de vendas
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

