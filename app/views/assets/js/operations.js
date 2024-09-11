const formOperation = document.getElementById("form-operation");

$('#value').inputmask('currency', {
    prefix: 'R$ ',
    rightAlign: false,
    radixPoint: ',',
    groupSeparator: '.',
    autoGroup: true,
    allowMinus: false,
    digits: 0, // Sem casas decimais
    digitsOptional: false, // Não permite casas decimais opcionais
    placeholder: '0'
})

$('#date').inputmask('99/99/9999')

const $table = $('#table-operations').dataTable({
    iDisplayLength: 5,
    pageLength: 5,
    lengthMenu: [5, 10, 15, 20],
    language: {
        lengthMenu: "Exibir registros _MENU_ por página",
        zeroRecords: "Registros não encontrados",
        info: "Mostrando a página _PAGE_ de _PAGES_",
        infoEmpty: "Não há registros disponíveis",
        emptyTable: "Não há registros disponíveis",
        infoFiltered: "filtrado do total de _MAX_ registros",
        search: "Pesquisar",
        paginate: {
            next: "Próximo",
            previous: "Anterior"
        }
        
    }
})

const instance = $table.api()

formOperation.addEventListener("submit", (e) =>  {
    e.preventDefault();
    
    const [ date, value ] = e.target
    
    instance.row.add([ date.value, value.value ]).draw()
})