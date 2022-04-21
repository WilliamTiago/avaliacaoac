function formatMoney(value){
    var formatter = new Intl.NumberFormat('pr-BR', {
        style: 'currency',
        currency: 'BRL',
    });
      
    return formatter.format(value);
}

function formatDate(value){
    const date = value;
    const [year, month, day] = date.split('-');
    const result = [month, day, year].join('/');
    return result;
}