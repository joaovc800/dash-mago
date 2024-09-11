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
    'stoploss' => 'stoplos',
    'stopwin' => 'stopwin'
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
            $value = $json[$postKey];
        }
        
        $collection[$column] = $value;
    }
}

print_r($collection);
exit();

$user = new User([
    "email" => $_SESSION['auth']['username'],
    "passwordhash" => $_SESSION['auth']['password']
]);

/* $informations = $user->updateInformations();

Response::success($informations, 'Dados retornados com sucesso'); */

/* if($update['statement']){
    Response::success(message:'Senha atualizada com sucesso!');
}

Response::fail(message:'Houve um erro ao atualizar a senha, por favor tente novamente!'); */