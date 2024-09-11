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

        <?php require_once './profile-include.php' ?>

        <h1 class="title">Perfil</h1>

        <div class="is-flex is-flex-direction-column is-gap-4">
            <div class="is-flex is-flex-direction-column is-align-items-center is-gap-2">
                <figure class="image is-128x128">
                    <img class="is-rounded" src="https://bulma.io/assets/images/placeholders/128x128.png" />
                </figure>
                <span class="subtitle is-4">
                    <?=$_SESSION['auth']['username']?>
                </span>
            </div>
            <form id="form-profile" class="is-flex is-flex-direction-column is-gap-1">
                <div class="field">
                    <label for="email" class="label is-clickable">E-mail</label>
                    <div class="control">
                        <input id="email" class="input" type="email" placeholder="E-mail" value="<?=$_SESSION['auth']['username']?>" disabled required>
                    </div>
                </div>
                
                <div class="is-flex is-flex-direction-column is-gap-1">

                    <h1 class="title is-5 m-0 py-2">Alteração de senha</h1>

                    <div class="field">
                        <label for="new-password" class="label is-clickable">Senha</label>
                        <div class="control">
                            <input id="new-password" class="input" type="password" placeholder="********" required>
                        </div>
                        <p refer="new-password" class="help"></p>
                    </div>

                    <div class="field">
                        <label for="confirm-password" class="label is-clickable">Confirmar senha</label>
                        <div class="control">
                            <input id="confirm-password" class="input" type="password" placeholder="********" required>
                        </div>
                        <p refer="confirm-password" class="help"></p>
                    </div>

                    <div class="field">
                        <p class="control">
                            <button type="submit" class="button has-background-green-medium">
                                Salvar nova senha
                            </button>
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script type="module" src="./assets/js/resetpassword.js"></script>
</body>

</html>