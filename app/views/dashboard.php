<?php
require_once realpath(dirname(__DIR__, 1) . '/controllers/checkSession.php');
?>

<!DOCTYPE html>
<html lang="pt-br" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../../public/src/assets/css/styles.css">
</head>

<body>
    <div class="container is-max-tablet p-5">
        <div class="is-flex is-justify-content-flex-end">
            <div class="dropdown is-active">
                <div class="dropdown-trigger">
                    <div class="is-flex is-align-items-center is-gap-1 is-justify-content-flex-end" aria-haspopup="true" aria-controls="dropdown-user">
                        <span><?php echo $_SESSION['auth']['username'] ?></span>
                        <figure class="image is-48x48">
                            <img class="is-rounded" src="https://bulma.io/assets/images/placeholders/128x128.png" />
                        </figure>
                    </div>
                </div>
                <div class="dropdown-menu" id="dropdown-user" role="menu">
                    <div class="dropdown-content">
                        <a href="../../public/" class="dropdown-item is-danger is-flex is-align-items-center is-gap-1">
                            Sair
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <h1 class="title">Carteira</h1>
        
        <div class="buttons">
            <button class="button is-hoverable is-rounded has-text-light has-background-green-light">Inicio</button>
            <button class="button is-hoverable is-rounded has-text-light">Configurações</button>
        </div>

        <div class="pt-6">
            <h1 class="title">Total</h1>

            <div class="py-3 is-flex is-flex-direction-column is-gap-4">
                <div class="card is-flex is-flex-direction-column m-0 px-4 py-2 has-background-purple-dark has-text-light">
                    <span>Valor total da banca</span>
                    <span class="is-size-5 has-text-weight-bold">R$ 1.530,00</span>
                </div>

                <div class="card is-flex is-flex-direction-column m-0 px-4 py-2 has-background-purple-dark has-text-light">
                    <span>Total de entradas</span>
                    <span class="is-size-5 has-text-weight-bold">5</span>
                </div>

                <div data-profit="win" class="card is-flex is-flex-direction-column m-0 px-4 py-2 has-text-light">
                    <span>Lucro total</span>
                    <span class="is-size-5 has-text-weight-bold">R$ 500</span>
                </div>
            </div>
            
            <div class="buttons pt-5 is-flex is-justify-content-space-between">
                <button class="button is-hoverable is-rounded has-text-light">Tutoriais</button>
                <button class="button is-hoverable is-rounded has-text-light">Cadastrar</button>
            </div>

            <div class="is-flex pt-3">
                <button data-state="on" class="py-3 button is-fullwidth is-hoverable has-text-light has-text-weight-bold is-uppercase">Ligar</button>
            </div>
        </div>
    </div>
</body>

</html>