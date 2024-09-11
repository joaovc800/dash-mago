<div class="is-flex is-justify-content-flex-end">
    <div class="dropdown">
        <div id="dropdown-trigger-menu" class="dropdown-trigger is-clickable">
            <div class="is-flex is-align-items-center is-gap-1 is-justify-content-flex-end" aria-haspopup="true" aria-controls="dropdown-user">
                <span><?php echo $_SESSION['auth']['username'] ?></span>
                <figure class="image is-48x48">
                    <img class="is-rounded" src="https://bulma.io/assets/images/placeholders/128x128.png" />
                </figure>
            </div>
        </div>
        <div class="dropdown-menu" id="dropdown-user" role="menu">
            <div class="dropdown-content">
                <a href="./profile.php" class="dropdown-item is-danger is-flex is-align-items-center is-gap-1">
                    Perfil
                    <i class="fa-solid fa-user"></i>
                </a>
                <a href="../../public/" class="dropdown-item is-danger is-flex is-align-items-center is-gap-1">
                    Operações
                    <i class="fa-solid fa-cogs"></i>
                </a>
                <a href="./dashboard.php" class="dropdown-item is-danger is-flex is-align-items-center is-gap-1">
                    Dashboard
                    <i class="fa-solid fa-chart-simple"></i>
                </a>
                <hr class="dropdown-divider" />
                <a href="../../public/" class="dropdown-item is-danger is-flex is-align-items-center is-gap-1">
                    Sair
                    <i class="fa-solid fa-right-from-bracket"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    const dropdownTrigger = document.getElementById("dropdown-trigger-menu")
    const dropdown = dropdownTrigger.closest(".dropdown")
    
    dropdownTrigger.addEventListener('click', ( { target }) => {
        const fn = dropdown.classList.contains("is-active") ? 'remove' : 'add'
        dropdown.classList[fn]("is-active")
    })

    document.addEventListener('click', (event) => {
        if (!dropdown.contains(event.target) && !dropdownTrigger.contains(event.target)) {
            dropdown.classList.remove("is-active");
        }
    })
</script>

<script defer src="./assets/js/notify.js"></script>
<script defer src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script defer src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.9/jquery.inputmask.min.js" integrity="sha512-F5Ul1uuyFlGnIT1dk2c4kB4DBdi5wnBJjVhL7gQlGh46Xn0VhvD8kgxLtjdZ5YN83gybk/aASUAlpdoWUjRR3g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

