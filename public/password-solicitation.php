<!DOCTYPE html>
<html lang="pt-br" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar nova senha</title>
    <link rel="stylesheet" href="./src/assets/css/styles.css">
</head>

<body>
    <div class="container is-max-tablet p-5">
        <section class="hero is-fullheight">
            <div class="hero-body">
                <div class="container">
                    <div class="columns is-centered">
                        <div class="column">
                            <form id="form-password-solicitation" class="box is-flex is-flex-direction-column is-gap-3">
                                <div class="is-flex is-flex-direction-column is-justify-content-center has-text-centered is-gap-1">
                                    <i class="fa-solid fa-lock is-size-2 has-text-light"></i>
                                    <h1 class="title">Esqueceu sua senha ?</h1>
                                </div>
                                <div class="field">
                                    <label for="email" class="label is-clickable">E-mail</label>
                                    <div class="control">
                                        <input name="email" id="email" type="email" placeholder="Digite seu e-mail para gerar link de reset" class="input" required>
                                    </div>
                                    <p class="help">Digite seu e-mail para gerar link de reset</p>
                                </div>
                                <div class="field">
                                    <button type="submit" class="button is-fullwidth has-background-green-medium py-2">
                                        Solicitar link
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="../app/views/assets/js/notify.js"></script>
    <script type="module" src="./src/assets/js/passwordpermission.js"></script>
</body>
</html>