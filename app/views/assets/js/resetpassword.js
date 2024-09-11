import { requests, api } from "./utils.js"

const formProfile = document.getElementById('form-profile')

formProfile.addEventListener('submit', async ( e ) => {
    e.preventDefault()

    const [ email, password, confirmPassword ] = e.target

    const inputsPassword = [
        {
            input: password,
            messages: {
                error: "Senhas não conferem"
            }
        },
        {
            input: confirmPassword,
            messages: {
                error: "Senhas não conferem"
            }
        },
    ]

    inputsPassword.forEach(({ input }) => { 
        const refer = document.querySelector(`p[refer="${input.id}"]`)
        input.classList.remove('is-danger')
        refer.innerText = ''
        refer.classList.remove('is-danger')
    })
    
    if(password.value !== confirmPassword.value){
        inputsPassword.forEach(({ input, messages }) => {
            const refer = document.querySelector(`p[refer="${input.id}"]`)
            input.classList.add('is-danger')
            refer.innerText = messages.error
            refer.classList.add('is-danger')
        })
        return
    }

    const { message, success } = await requests.post(api.base('resetPassword'), {
        password: confirmPassword.value
    }, { isLoadingInput: inputsPassword})

    const notyf = new Notyf()

    const type = success ? 'success' : 'error'

    notyf[type](message)

    if(success) inputsPassword.forEach(({input}) => input.value = '')
})