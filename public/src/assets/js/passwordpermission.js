import { requests, api } from "../../../../app/views/assets/js/utils.js"

const formPasswordSolicitation = document.getElementById("form-password-solicitation")

const duration = 3000
const notyf = new Notyf({ duration })

formPasswordSolicitation.addEventListener("submit", async (e) => {
    e.preventDefault()

    const [ email, button ] = e.target

    const [ baseApi ] = window.location.href.split("public")

    email.setAttribute('disabled', 'disabled')
    button.setAttribute('disabled', 'disabled')

    const { message, success } = await requests.post(`${baseApi}app/controllers/sendTokenEmail.php`, {
        email: email.value
    })

    if(!success){
        email.removeAttribute('disabled')
        button.removeAttribute('disabled')
        notyf.error(message)
        return
    }

    notyf.success(message)

    setTimeout(() => {
        window.location.replace("./index.php")
    }, (duration + 500) )
})