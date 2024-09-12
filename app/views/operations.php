<?php
require_once realpath(dirname(__DIR__, 1) . '/controllers/checkSession.php');
?>

<!DOCTYPE html>
<html lang="pt-br" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operações</title>
    <link rel="stylesheet" href="../../public/src/assets/css/styles.css">
</head>

<body>
    <div class="container is-max-tablet p-5">

        <?php require_once './profile-include.php' ?>

        <h1 class="title">Minhas operações</h1>
        
        <form id="form-operation" class="is-flex is-gap-2 is-align-items-center mb-3">
            <div class="field">
                <label for="date" class="label is-clickable">Data da operação</label>
                <div class="control">
                    <input inputmode="numeric" id="date" class="input" type="tel" placeholder="Exemplo: 09/07/2020" required>
                </div>
                <p class="help">Data da realização da operação</p>
            </div>
            <div class="field">
                <label for="value" class="label is-clickable">Valor obtido</label>
                <div class="control">
                    <input id="value" class="input" type="text" placeholder="Exemplo: R$ 100" required>
                </div>
                <p class="help">Valor da operação feita lucro ou perca</p>
            </div>
            <div class="field">
                <p class="control">
                    <button type="submit" class="py-2 button has-background-green-medium is-fullwidth is-hoverable has-text-light has-text-weight-bold is-uppercase">
                        Salvar
                    </button>
                </p>
            </div>
        </form>

        <table class="table is-striped is-bordered" id="table-operations">
            <thead>
                <tr>
                    <td>Data</td>
                    <td>Valor</td>
                    <td>Status</td>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <script type="module" src="./assets/js/operations.js"></script>
</body>

</html>