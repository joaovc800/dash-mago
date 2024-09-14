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

        <form id="form-operation" class="is-flex is-gap-2 is-align-items-center mb-2">
            <div class="field">
                <label for="date" class="label is-clickable">Data</label>
                <div class="control">
                    <input inputmode="numeric" id="date" class="input" type="tel" placeholder="Exemplo: 09/07/2020" required>
                </div>
                <p class="help">Data da operação</p>
            </div>
            <div class="field">
                <label for="value" class="label is-clickable">Valor obtido</label>
                <div class="control">
                    <input id="value" class="input" type="text" placeholder="Exemplo: R$ 100" required>
                </div>
                <p class="help">Lucro ou perca</p>
            </div>
            <div class="field">
                <p class="control">
                    <button type="submit" class="py-2 button has-background-green-medium is-fullwidth is-hoverable has-text-light has-text-weight-bold is-uppercase">
                        Salvar
                    </button>
                </p>
            </div>
        </form>

        <table class="table is-striped is-bordered mb-2" id="table-operations">
            <thead>
                <tr>
                    <td>Data</td>
                    <td>Valor</td>
                    <td>Status</td>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        <div class="my-3 columns is-tablet">
            <div class="column">
                <div class="card">
                    <div class="card-content">
                        <div class="content">
                            <h1 class="title is-4 mb-2">Dias operados</h1>
                            <span id="daysOperated" class="tag is-large has-background-purple-medium has-text-light">0</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="card">
                    <div class="card-content">
                        <div class="content">
                            <h1 class="title is-4 mb-2">Lucro</h1>
                            <span id="profit" class="tag is-large has-text-light">R$ 0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="chart-container" class="my-2 is-hidden">
            <h1 class="title my-2">Gráfico de Lucro e Dias Operados</h1>

            <div class="is-flex is-align-items-center is-gap-2 my-2">
                <label for="yearSelector">Selecione o Ano:</label>
                <div class="select">
                    <select class="select" id="yearSelector">
                    </select>
                </div>
            </div>

            <canvas id="chart-operations"></canvas>
        </div>
    </div>

    <script type="module" src="./assets/js/operations.js"></script>
</body>

</html>