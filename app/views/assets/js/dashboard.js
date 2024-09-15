import { requests, api, formatCurrency } from './utils.js'

const buttonDashboard = document.getElementById('dashboard-button')
const buttonConfig = document.getElementById('config-button')
const divDashboard = document.getElementById('dashboard')
const divConfig = document.getElementById('config')
const title = document.getElementById('title')
const formConfig = document.getElementById('form-config')

const buttonOnOff = document.getElementById('on-off')

const { data, success, message } = await requests.get(api.base('getInformations'))

const notyf = new Notyf()

function fillInformationsDashboard(data){
    let profit = parseInt(data.currentBankroll) - parseInt(data.initialBankroll)

    if(parseInt(data.currentBankroll) == 0) profit = 0

    const configInformations = {
        "profit" : formatCurrency(profit),
        "bankrollTotal" : formatCurrency(data.initialBankroll),
        "entries" : data.operations,
    }

    for (const key in configInformations) {
        const element = document.getElementById(key)
        element.innerText = configInformations[key]

        if(key === "profit"){
            const winOrLoss = profit >= 0 ? 'win' : 'loss'
            
            element.closest('div').setAttribute('data-profit', winOrLoss)
        }
    }
}

if(success){

    divDashboard.setAttribute('active', 'true')
    divConfig.setAttribute('active', 'true')

    $('#init-banroll, #stopwin, #stoploss').inputmask('currency', {
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

    const configInputs = {
        "init-banroll" : data.initialBankroll,
        "stopwin" : data.stopwin,
        "stoploss" : data.stoploss,
        "chip" : data.chip,
        "gale" : data.gale,
    }

    for (const key in configInputs) {
        const input = document.getElementById(key)
        input.value = configInputs[key]
    }

    fillInformationsDashboard(data)

    buttonDashboard.addEventListener('click', ({ target }) => {
        buttonConfig.classList.remove('has-background-green-light')
        target.classList.add('has-background-green-light')
        divConfig.classList.add('is-hidden')
        divDashboard.classList.remove('is-hidden')

        title.innerHTML = target.getAttribute('data-title')
    })

    buttonConfig.addEventListener('click', ({ target }) => {
        buttonDashboard.classList.remove('has-background-green-light')
        target.classList.add('has-background-green-light')
        divDashboard.classList.add('is-hidden')
        divConfig.classList.remove('is-hidden')

        title.innerHTML = target.getAttribute('data-title')
    })

    const configStates = {
        desligar: {
            state: "on",
            changeState: "off",
            text: "Ligar",
            changeStateText: "ligar",
        },
        desligado: {
            state: "on",
            changeState: "off",
            text: "Ligar",
            changeStateText: "ligar",
        },
        ligar: {
            state: "off",
            changeState: "on",
            text: "Desligar",
            changeStateText: "desligar",
        },
        ligado: {
            state: "off",
            changeState: "on",
            text: "Desligar",
            changeStateText: "desligar",
        },
    }

    console.log(data);
    
    const { state, text } = configStates[data.status] ?? configStates['desligado']
    buttonOnOff.setAttribute("data-state", state)
    buttonOnOff.setAttribute("data-state-text", data.status == "" ? 'desligado' : data.status)
    buttonOnOff.innerText = text


    buttonOnOff.addEventListener('click', async ({ target }) => {
        const currentState = target.getAttribute("data-state-text")

        const stateText = configStates[currentState].changeStateText

        const { data, success, message } = await requests.post(api.base('updateInformations'), {
            status: stateText
        })

        if(success){
            
            target.setAttribute('data-state', configStates[data.status].state)
            target.setAttribute('data-state-text', data.status)
            target.innerHTML = configStates[data.status].text

            notyf.success('Status alterado com sucesso')
            return
        }

        notyf.error('Error ao alterar o status')
    })

    formConfig.addEventListener('submit', async (e) => {
        e.preventDefault()

        const [ initialBankroll, stopwin, stoploss, chip, gale, save ] = e.target

        console.log(initialBankroll.value, stopwin.value, stoploss.value);
        const initialBankrollTrueValue = Number(initialBankroll.value.replace('R$ ','').split('.').join(''))
        const stopwinTrueValue = Number(stopwin.value.replace('R$ ','').split('.').join(''))
        const stoplossTrueValue = Number(stoploss.value.replace('R$ ','').split('.').join(''))
        
        
        const { success, message } = await requests.post(api.base('updateInformations'), {
            initialBankroll: initialBankrollTrueValue,
            stopwin: stopwinTrueValue,
            stoploss: stoplossTrueValue,
            chip: chip.value,
            gale: gale.value,
            operations: 0,
            currentBankroll: 0
        }, { isLoadingInput: [
            { input: initialBankroll },
            { input: stopwin },
            { input: stoploss },
            { input: chip },
            { input: gale },
            { input: save },
        ]})

        const notyf = new Notyf()

        if(success){
            notyf.success(message)

            const { data } = await requests.get(api.base('getInformations'))

            fillInformationsDashboard(data)
            return
        }

        notyf.error(message)
        
    })
}else{
    notyf.error(message)
}