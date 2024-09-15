import { requests, api, formatCurrency } from './utils.js'
import 'https://cdn.jsdelivr.net/npm/chart.js'

const notyf = new Notyf()

const formOperation = document.getElementById("form-operation")
const daysOperated = document.getElementById("daysOperated")
const profit = document.getElementById("profit")
const yearSelector = document.getElementById("yearSelector")
const chartContainer = document.getElementById("chart-container")

const ctx = document.getElementById('chart-operations').getContext('2d')

const chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [],
        datasets: [{
            type: 'bar',
            label: 'Dias Operados',
            data: [],
            borderColor: 'rgba(159, 55, 254, 1)',
            backgroundColor: 'rgba(159, 55, 254, 0.2)',
            yAxisID: 'y1',
        }, {
            type: 'line',
            label: 'Lucro',
            data: [],
            borderColor: 'rgba(89, 149, 1, 1)',
            backgroundColor: 'rgba(89, 149, 1, 0.2)',
            yAxisID: 'y2',
        }]
    },
    options: {
        responsive: true,
        scales: {
            x: {
                beginAtZero: true,
                ticks: {
                    maxRotation: 50,
                    minRotation: 45
                },
                title: {
                    display: true,
                    text: 'Meses ou Períodos'
                }
            },
            y1: {
                type: 'linear',
                position: 'left',
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Dias Operados'
                },
                ticks: {
                    callback: function (value) {
                        return Number.isInteger(value) ? value : '';
                    }
                }
            },
            y2: {
                type: 'linear',
                position: 'right',
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Lucro'
                },
                grid: {
                    drawOnChartArea: true
                },
                ticks: {
                    callback: function (value) {
                        return `R$ ${value.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
                    }
                }
            }
        }
    }
})

function formatData(year, dataMonths) {

    const monthNames = [
        "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho",
        "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"
    ]

    const filteredData = dataMonths.filter(data => data.year === year)

    const dataObject = monthNames.reduce((acc, month, index) => {
        const monthIndex = (index + 1).toString()
        const monthData = filteredData.find(d => d.month === monthIndex)

        acc[month] = {
            daysOperated: monthData ? parseInt(monthData.total_days_operated, 10) : 0,
            profit: monthData ? parseFloat(monthData.total_profit, 10) : 0
        }

        return acc
    }, {})

    return dataObject
}

function updateChart(selectedYear, dataMonths) {

    const dataChart = {
        [selectedYear]: formatData(selectedYear, dataMonths)
    };

    const labels = Object.keys(dataChart[selectedYear])
    const daysOperatedData = labels.map(month => dataChart[selectedYear][month].daysOperated)
    const profitData = labels.map(month => dataChart[selectedYear][month].profit)

    chart.data.labels = labels

    chart.data.datasets[0].data = daysOperatedData
    chart.data.datasets[1].data = profitData

    chart.update()
}

function updateOperationInformations(data) {
    const { daysOperatedValue, profitValue } = data.total.reduce((accumulator, { daysOperated, profit }) => {
        accumulator.daysOperatedValue += parseInt(daysOperated)
        accumulator.profitValue += parseInt(profit)

        return accumulator
    }, { daysOperatedValue: 0, profitValue: 0 })

    const isDaysOrDay = daysOperatedValue > 1 ? 'dias' : 'dia'

    daysOperated.innerText = `${daysOperatedValue} ${isDaysOrDay}`
    daysOperated.closest('.card').classList.add('is-boxshadow-purple-medium')

    const isPrifitPositive = profitValue > 0 ? {
        color: 'has-background-green-medium',
        icon: '<sup class="mx-2 fa-solid fa-arrow-trend-up"></sup>',
        boxshadow: 'is-boxshadow-green-medium'
    } : {
        color: 'has-background-danger-medium',
        icon: '<sup class="mx-2 fa-solid fa-arrow-trend-down"></sup>',
        boxshadow: 'is-boxshadow-danger-medium'
    }

    profit.classList.remove('has-background-green-medium', 'has-background-danger-medium')
    profit.classList.add(isPrifitPositive.color)

    profit.closest('.card').classList.remove('is-boxshadow-green-medium', 'is-boxshadow-danger-medium')
    profit.closest('.card').classList.add(isPrifitPositive.boxshadow)

    profit.innerHTML = `${formatCurrency(profitValue)} ${isPrifitPositive.icon}`
}

$('#value').inputmask('currency', {
    prefix: 'R$ ',
    rightAlign: false,
    radixPoint: ',',
    groupSeparator: '.',
    autoGroup: true,
    allowMinus: true,
    digits: 0,
    digitsOptional: false,
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

function addRow({ date, initialBankroll, value, instance, id }) {

    const balance = initialBankroll + (value)

    const { color, text } = balance > initialBankroll ?
        {
            color: 'has-background-green-medium',
            text: 'Positivo'
        } :
        {
            color: 'has-background-danger-medium',
            text: 'Negativo'
        }

    const tag = `
        <span class="tag ${color} has-text-light">
            ${text}
            <button data-id="${id}" class="delete is-small delete-operation"></button>
        </span>
    `
    instance.row.add([date, formatCurrency(value), tag]).draw()
}

const instance = $table.api()

const { data, message, success } = await requests.get(api.base('getOperations'))

const { data: { initialBankroll } } = await requests.get(api.base('getInformations'))

if (!success) {
    notyf.error(message)
}

formOperation.addEventListener("submit", async (e) => {
    e.preventDefault()

    const [date, value, button] = e.target

    const data = {
        date: date.value.split('/').reverse().join('-'),
        value: value.value.replace('R$ ', '').split('.').join('')
    }

    const { success, message, data: { id } } = await requests.post(api.base("createOperation"), data, {
        isLoadingInput: [
            { input: date },
            { input: value },
            { input: button },
        ]
    })

    if (success) {

        addRow({
            date: date.value,
            value: data.value,
            id: id,
            instance: instance,
            initialBankroll: initialBankroll
        })

        notyf.success(message)

        const response = await requests.get(api.base('getOperations'))

        updateChart(response.data.total[0].year, response.data.months)

        updateOperationInformations(response.data)

        yearSelector.innerHTML = ''
        response.data.total.forEach(({ year }) => {
            yearSelector.innerHTML += `<option value="${year}">${year}</option>`
        })

        if (chartContainer.classList.contains('is-hidden')) {
            chartContainer.classList.remove('is-hidden')
        }

        return
    }

    notyf.error(message)
})

$('body').on('click', '.delete-operation', async function ({ target }) {

    target.setAttribute('disabled', 'disabled')

    const id = target.getAttribute('data-id')

    const { success, message } = await requests.post(api.base('deleteOperation'), { id })

    if (!success) {
        notyf.error(message)
        return
    }

    notyf.success(message)

    const row = target.closest('tr')
    instance.row(row).remove().draw()

    const response = await requests.get(api.base('getOperations'))

    yearSelector.innerHTML = ''

    if (response.data.total.length > 0) {
        updateChart(response.data.total[0].year, response.data.months)

        updateOperationInformations(response.data)


        response.data.total.forEach(({ year }) => {
            yearSelector.innerHTML += `<option value="${year}">${year}</option>`
        })
    }

})

if (success) {

    updateOperationInformations(data)

    if (!data.erro) {
        data.all.forEach(({ date, value, id }) => addRow({ date, value, id, instance, initialBankroll }))
    }

    data.total.forEach(({ year }) => {
        yearSelector.innerHTML += `<option value="${year}">${year}</option>`
    })

    updateChart(data.total[0].year, data.months)

    chartContainer.classList.remove('is-hidden')
}

yearSelector.addEventListener('change', async (event) => {
    const { data } = await requests.get(api.base('getOperations'))
    updateChart(event.target.value, data.months)
})

instance.on('draw', function () {
    tippy('.delete-operation', {
        content: 'Deletar operação',
        placement: 'top',
        arrow: true
    });
})