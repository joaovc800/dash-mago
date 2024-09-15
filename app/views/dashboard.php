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

        <h1 id="title" class="title">Carteira</h1>

        <div class="buttons">
            <button data-title="Carteira" id="dashboard-button" class="button is-hoverable is-rounded has-text-light has-background-green-light">Inicio</button>
            <button data-title="Configurações" id="config-button" class="button is-hoverable is-rounded has-text-light">Configurações</button>
        </div>

        <div id="dashboard" class="pt-5">
            <h1 class="title">Total</h1>

            <div class="py-3 is-flex is-flex-direction-column is-gap-4">
                <div class="is-shadowless card is-flex is-flex-direction-column m-0 px-4 py-2 has-background-purple-dark has-text-light">
                    <span>Valor total da banca</span>
                    <span id="bankrollTotal" class="is-size-5 has-text-weight-bold">R$ 0,00</span>
                </div>

                <div class="is-shadowless card is-flex is-flex-direction-column m-0 px-4 py-2 has-background-purple-dark has-text-light">
                    <span>Total de entradas</span>
                    <span id="entries" class="is-size-5 has-text-weight-bold">0</span>
                </div>

                <div data-profit="" class="is-shadowless card is-flex is-flex-direction-column m-0 px-4 py-2 has-text-light">
                    <span>Lucro total</span>
                    <span id="profit" class="is-size-5 has-text-weight-bold">R$ 0</span>
                </div>
            </div>

            <div class="buttons pt-5 is-flex is-justify-content-space-between">
                <a href="#" class="button is-hoverable is-rounded has-text-light">Tutoriais</a>
                <a href="#" class="button is-hoverable is-rounded has-text-light">Cadastrar</a>
            </div>

            <div class="is-flex pt-3">
                <button id="on-off" class="py-3 button is-fullwidth is-hoverable has-text-light has-text-weight-bold is-uppercase"></button>
            </div>
        </div>
        <div id="config" class="is-hidden">
            <form id="form-config" class="is-flex is-flex-direction-column is-gap-1">
                <div class="field">
                    <label for="init-banroll" class="label is-clickable">Banca inicial</label>
                    <div class="control">
                        <input id="init-banroll" class="input" type="text" placeholder="Digite a banca inicial" value="" required>
                    </div>
                </div>

                <div class="field">
                    <label for="stopwin" class="label is-clickable">Stop Win</label>
                    <div class="control">
                        <input id="stopwin" class="input" type="text" placeholder="Digite o valor desejado para parar quando atingir esse ganho. Exemplo: 1000" value="" required>
                    </div>
                    <p class="help">Insira o valor para parar quando atingir esse ganho.</p>
                </div>

                <div class="field">
                    <label for="stoploss" class="label is-clickable">Stop Loss</label>
                    <div class="control">
                        <input id="stoploss" class="input" type="text" placeholder="Digite o valor desejado para parar quando atingir esse perdido. Exemplo: 1000" value="" required>
                    </div>
                    <p class="help">Insira o valor para parar quando atingir essa perda.</p>
                </div>

                <div class="field">
                    <label for="chip" class="label is-clickable">Valor da ficha</label>
                    <div class="select is-fullwidth control">
                        <select id="chip">
                            <option value="1">R$ 0,50</option>
                            <option value="2">R$ 1,00</option>
                            <option value="3">R$ 2,50</option>
                            <option value="4">R$ 5,00</option>
                            <option value="5">R$ 20,00</option>
                            <option value="6">R$ 50,00</option>
                            <option value="7">R$ 100,00</option>
                        </select>
                    </div>
                    <p class="help">Selecione o valor da ficha</p>
                </div>

                <div class="field">
                    <label for="gale" class="label is-clickable">Nº de gale</label>
                    <div class="select is-fullwidth control">
                        <select id="gale">
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                    </div>
                    <p class="help">Escolha o número de repetições da estratégia gale.</p>
                </div>

                <div class="field">
                    <p class="control">
                        <button type="submit" class="py-3 button has-background-purple-medium is-fullwidth is-hoverable has-text-light has-text-weight-bold is-uppercase">
                            Salvar
                        </button>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <script type="module" src="./assets/js/dashboard.js"></script>
</body>

</html>