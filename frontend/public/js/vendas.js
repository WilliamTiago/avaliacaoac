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