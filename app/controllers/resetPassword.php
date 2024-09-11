<?php
require_once __DIR__ . '/checkSession.php';
require_once realpath(dirname(__DIR__, 1) . '/models/User.php');
require_once realpath(dirname(__DIR__, 1) . '/core/Response.php');

header('Content-Type: application/json');

$json = json_decode(file_get_contents('php://input'), true);

$user = new User([
    "email" => $_SESSION['auth']['username'],
    "password" => $_SESSION['auth']['password']
]);

$update = $user->updatePassword($json['password'], $_SESSION['auth']['id']);

if($update['statement']){
    Response::success(message:'Senha atualizada com sucesso!');
}

Response::fail(message:'Houve um erro ao atualizar a senha, por favor tente novamente!');