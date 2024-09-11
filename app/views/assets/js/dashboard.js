const buttonDashboard = document.getElementById('dashboard-button')
const buttonConfig = document.getElementById('config-button')
const divDashboard = document.getElementById('dashboard')
const divConfig = document.getElementById('config')
const title = document.getElementById('title')

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