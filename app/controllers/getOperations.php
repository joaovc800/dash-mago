<?php
require_once __DIR__ . '/checkSession.php';
require_once realpath(dirname(__DIR__, 1) . '/models/Operation.php');
require_once realpath(dirname(__DIR__, 1) . '/core/Response.php');

header('Content-Type: application/json');

$operation = new Operation($_SESSION['auth']['id']);

$all = $operation->getAllOperations();

if(!isset($all['erro'])){

    $total = $operation->getTotalOperations();

    $byMonths = $operation->getTotalOperationsByMonths();

    Response::success([
        'all' => $all,
        'total' => $total['fetch'],
        'months' => $byMonths['fetch']
    ], 'Dados retornados com sucesso');
}

Response::fail([], 'Você ainda não tem operações registradas.');