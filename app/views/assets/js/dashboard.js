import { requests, api, formatCurrency } from './utils.js'

const buttonDashboard = document.getElementById('dashboard-button')
const buttonConfig = document.getElementById('config-button')
const divDashboard = document.getElementById('dashboard')
const divConfig = document.getElementById('config')
const title = document.getElementById('title')
const formConfig = document.getElementById('form-config')

const buttonOnOff = document.getElementById('on-off')

const { data, success, message } = await requests.get(api.base('getInformations'))

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

const configInformations = {
    "profit" : formatCurrency(data.initialBankroll),
    "bankrollTotal" : formatCurrency(data.initialBankroll),
    "entries" : data.operations,
}

for (const key in configInformations) {
    const element = document.getElementById(key)
    element.innerText = configInformations[key]
}

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
    desligado: {
        state: "on",
        changeState: "off",
        text: "Ligar",
        changeStateText: "ligado",
    },
    ligado: {
        state: "off",
        changeState: "on",
        text: "Desligar",
        changeStateText: "desligado",
    },
}

const { state, text } = configStates[data.status]
buttonOnOff.setAttribute("data-state", state)
buttonOnOff.setAttribute("data-state-text", data.status)
buttonOnOff.innerText = text


buttonOnOff.addEventListener('click', async ({ target }) => {
    const currentState = target.getAttribute("data-state-text")

    const stateText = configStates[currentState].changeStateText

    const { data, success, message } = await requests.post(api.base('updateInformations'), {
        status: stateText
    })

    const notyf = new Notyf()

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

    const { success, message } = await requests.post(api.base('updateInformations'), {
        initialBankroll: initialBankroll.value,
        stopwin: stopwin.value,
        stoploss: stoploss.value,
        chip: chip.value,
        gale: gale.value,
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
        return
    }

    notyf.error(message)
    
})