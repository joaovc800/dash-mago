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

Response::success($informations, 'Dados retornados com sucesso');

/* if($update['statement']){
    Response::success(message:'Senha atualizada com sucesso!');
}

Response::fail(message:'Houve um erro ao atualizar a senha, por favor tente novamente!'); */