<?php
require_once __DIR__ . '/checkSession.php';
require_once realpath(dirname(__DIR__, 1) . '/models/User.php');
require_once realpath(dirname(__DIR__, 1) . '/core/Response.php');

header('Content-Type: application/json');

$json = json_decode(file_get_contents('php://input'), true);

$map = [
    'chip' => 'ficha',
    'gale' => 'gale',
    'initialBankroll' => 'banca_inicial',
    'currentBankroll' => 'banca_atual',
    'stoploss' => 'stoplos',
    'stopwin' => 'stopwin',
    'status' => 'status',
    'operations' => 'noperacoes'
];

$collection = [];

foreach ($map as $key => $column) {
    if (isset($json[$key])) {
        // Remove o prefixo "R$ " e converte para número decimal, se necessário
        if (strpos($json[$key], 'R$') === 0) {
            $value = str_replace(['R$ ', '.'], ['', ','], $json[$key]);
            $value = str_replace(',', '.', $value);
            $value = str_replace('.', '', $value);
        } else {
            $value = $json[$key];
        }
        
        $collection[$column] = $value;
    }
}

$user = new User([
    "email" => $_SESSION['auth']['username'],
    "passwordhash" => $_SESSION['auth']['password']
]);

$informations = $user->updateInformations($collection, $_SESSION['auth']['id']);

if($informations['statement']){
    Response::success($collection, 'Dados atualizados com sucesso!');
}

Response::fail([], 'Houve um erro ao atualizar os dados, por favor tente novamente!');