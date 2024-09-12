import { requests, api, formatCurrency } from './utils.js'

const notyf = new Notyf()

const formOperation = document.getElementById("form-operation");

$('#value').inputmask('currency', {
    prefix: 'R$ ',
    rightAlign: false,
    radixPoint: ',',
    groupSeparator: '.',
    autoGroup: true,
    allowMinus: true,
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

const { data, message, success } = await requests.get(api.base('getOperations'))

if(!success){
    notyf.error(message)
}

const { data: { initialBankroll }  } = await requests.get(api.base('getInformations'))

data.forEach(({ date, value }) => {
    
    const balance = initialBankroll + ( value )

    const { color, text } = balance > initialBankroll ? { color: 'is-success', text: 'Positivo' } : { color: 'is-danger', text: 'Negativo' }

    const tag = `<span class="tag ${color}">${text}</span>`
    instance.row.add([ date, formatCurrency(value), tag ]).draw()
})

formOperation.addEventListener("submit", async (e) =>  {
    e.preventDefault();
    
    const [ date, value, button ] = e.target
    
    const data = {
        date: date.value.split('/').reverse().join('-'),
        value: value.value.replace('R$ ','').split('.').join('')
    }

    const { success, message } = await requests.post(api.base("createOperation"), data , {
        isLoadingInput: [
            { input: date },
            { input: value },
            { input: button },
        ]
    })

    if(success){
        instance.row.add([ date.value, value.value ]).draw()
        notyf.success(message)
        return
    }

    notyf.error(message)
})