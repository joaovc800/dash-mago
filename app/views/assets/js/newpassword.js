import { requests, api } from "./utils.js"

const formResetPassword = document.getElementById('form-reset-password')

formResetPassword.addEventListener("submit", async (e) => {
    e.preventDefault()

    const params = new URLSearchParams(window.location.search)

    const [ password, button ] = e.target

    const { success, message } = await requests.post(api.base('newPassword'), { 
        password: password.value,
        token: params.get("token"),
    }, {
        isLoadingInput: [
            { input: password },
            { input: button },
        ]
    })

    const duration = 3000
    const notyf = new Notyf({ duration })

    if(success){
        notyf.success(message).on('dismiss', ({target, event}) => console.log(target, event));

        setTimeout(() => {
            window.location.replace("../../public/index.php")
        }, (duration + 500) )

        return
    }

    notyf.error(message)
    
})