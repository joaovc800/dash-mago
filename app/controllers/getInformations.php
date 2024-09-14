<?php
require_once __DIR__ . '/checkSession.php';
require_once realpath(dirname(__DIR__, 1) . '/models/User.php');
require_once realpath(dirname(__DIR__, 1) . '/core/Response.php');

header('Content-Type: application/json');

$user = new User([
    "email" => $_SESSION['auth']['username'],
    "passwordhash" => $_SESSION['auth']['password']
]);

$informations = $user->getDetails();

if($informations['signature']){
    Response::success($informations, 'Dados retornados com sucesso');
}

Response::fail([], 'Parece que sua assinatura não está ativa, renove para continuar usando os benefícios');