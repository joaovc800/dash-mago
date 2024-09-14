<?php
require_once __DIR__ . '/checkSession.php';
require_once realpath(dirname(__DIR__, 1) . '/models/Operation.php');
require_once realpath(dirname(__DIR__, 1) . '/core/Response.php');

header('Content-Type: application/json');

$json = json_decode(file_get_contents('php://input'), true);

$operation = new Operation($_SESSION['auth']['id']);

$delete = $operation->deleteOperation($json['id']);

if($delete['statement']){
    Response::success($delete, 'Registro deletado!');
}

Response::fail([], 'Erro ao deletar a operação');