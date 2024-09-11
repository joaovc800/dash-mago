<?php
require_once __DIR__ . '/checkSession.php';
require_once realpath(dirname(__DIR__, 1) . '/models/Operation.php');
require_once realpath(dirname(__DIR__, 1) . '/core/Response.php');

header('Content-Type: application/json');

$operation = new Operation($_SESSION['auth']['id']);

$all = $operation->getAllOperations();

Response::success($all, 'Dados retornados com sucesso');

/* if($update['statement']){
    Response::success(message:'Senha atualizada com sucesso!');
}

Response::fail(message:'Houve um erro ao atualizar a senha, por favor tente novamente!'); */