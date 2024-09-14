<?php
require_once __DIR__ . '/checkSession.php';
require_once realpath(dirname(__DIR__, 1) . '/models/Operation.php');
require_once realpath(dirname(__DIR__, 1) . '/core/Response.php');

header('Content-Type: application/json');

$json = json_decode(file_get_contents('php://input'), true);

$operation = new Operation($_SESSION['auth']['id']);

$result = $operation->createOperation([
    'date' => $json['date'],
    'value' => (int) $json['value'],
    'iduser' => (int) $_SESSION['auth']['id']
]);

if($result['statement']){
    $json = array_merge($json, [ 'id' => $result['id']]);

    Response::success($json, 'Operação salva com sucesso!');
}

Response::fail([], 'Houve um erro ao incluir a operação, por favor tente novamente!');