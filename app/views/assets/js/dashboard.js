import { requests, api, isLoadingInput } from './utils.js'

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

const config = {
    "init-banroll" : data.initialBankroll,
    "stopwin" : data.stopwin,
    "stoploss" : data.stoploss,
    "chip" : data.chip,
    "gale" : data.gale,
}

for (const key in config) {
    const input = document.getElementById(key)
    input.value = config[key]
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

buttonOnOff.addEventListener('click', ({ target }) => {
    const configStates = {
        desligado: {
            state: "off",
            text: 'Desligar'
        },
        ligado: {
            state: "on",
            text: 'Ligar'
        },
    }

    target.setAttribute('data-state', configStates['desligado'].state)
    target.innerHTML = configStates['desligado'].text

    const notyf = new Notyf()

    notyf.success('Status alterado com sucesso')
})

formConfig.addEventListener('submit', (e) => {
    e.preventDefault()

    const [ initialBankroll, stopwin, stoploss, chip, gale, save ] = e.target

    requests.post(api.base('updateInformations'), {
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
    
})